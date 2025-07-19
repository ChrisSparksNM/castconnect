import asyncio
from playwright.async_api import async_playwright
import time
import random
import logging
import json
import re
from datetime import datetime, timezone
from config import Config
from fake_useragent import UserAgent
import tweepy

class TwitterScraper:
    def __init__(self):
        self.ua = UserAgent()
        self.browser = None
        self.context = None
        self.page = None
        self.api = None
        
        # Initialize Twitter API if credentials are provided
        if all([Config.TWITTER_API_KEY, Config.TWITTER_API_SECRET, 
                Config.TWITTER_ACCESS_TOKEN, Config.TWITTER_ACCESS_TOKEN_SECRET]):
            try:
                auth = tweepy.OAuthHandler(Config.TWITTER_API_KEY, Config.TWITTER_API_SECRET)
                auth.set_access_token(Config.TWITTER_ACCESS_TOKEN, Config.TWITTER_ACCESS_TOKEN_SECRET)
                self.api = tweepy.API(auth, wait_on_rate_limit=True)
                
                # Test authentication
                self.api.verify_credentials()
                logging.info("Successfully authenticated with Twitter API")
                
            except Exception as e:
                logging.warning(f"Twitter API authentication failed: {e}")
    
    async def setup_browser(self):
        """Initialize Playwright browser for Twitter/X"""
        try:
            playwright = await async_playwright().start()
            
            # Launch browser
            self.browser = await playwright.chromium.launch(
                headless=Config.USE_HEADLESS_BROWSER,
                args=[
                    '--no-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-blink-features=AutomationControlled',
                    '--disable-web-security',
                    '--disable-features=VizDisplayCompositor'
                ]
            )
            
            # Create context with random user agent
            self.context = await self.browser.new_context(
                user_agent=self.ua.random,
                viewport={'width': 1920, 'height': 1080},
                locale='en-US'
            )
            
            # Create page
            self.page = await self.context.new_page()
            
            # Add stealth settings
            await self.page.add_init_script("""
                Object.defineProperty(navigator, 'webdriver', {
                    get: () => undefined,
                });
                
                // Remove automation indicators
                delete window.cdc_adoQpoasnfa76pfcZLmcfl_Array;
                delete window.cdc_adoQpoasnfa76pfcZLmcfl_Promise;
                delete window.cdc_adoQpoasnfa76pfcZLmcfl_Symbol;
            """)
            
            logging.info("Twitter browser setup completed")
            return True
            
        except Exception as e:
            logging.error(f"Error setting up Twitter browser: {e}")
            return False
    
    async def close_browser(self):
        """Close browser and cleanup"""
        try:
            if self.page:
                await self.page.close()
            if self.context:
                await self.context.close()
            if self.browser:
                await self.browser.close()
            logging.info("Twitter browser closed")
        except Exception as e:
            logging.error(f"Error closing Twitter browser: {e}")
    
    def scrape_user_posts_api(self, username, max_posts=10):
        """Scrape posts using Twitter API (synchronous)"""
        posts = []
        
        if not self.api:
            logging.error("Twitter API not available")
            return posts
        
        try:
            username = username.lstrip('@')
            logging.info(f"Scraping Twitter posts for @{username} using API")
            
            # Get user tweets
            tweets = tweepy.Cursor(
                self.api.user_timeline,
                screen_name=username,
                exclude_replies=True,
                include_rts=False,
                tweet_mode='extended'
            ).items(max_posts)
            
            for tweet in tweets:
                try:
                    # Extract media URLs
                    media_urls = []
                    if hasattr(tweet, 'extended_entities') and 'media' in tweet.extended_entities:
                        for media in tweet.extended_entities['media']:
                            if media['type'] == 'photo':
                                media_urls.append(media['media_url_https'])
                    
                    post_data = {
                        'post_id': f"x_{tweet.id}",
                        'content': tweet.full_text,
                        'image_url': media_urls[0] if media_urls else None,
                        'post_url': f"https://x.com/{username}/status/{tweet.id}",
                        'posted_at': tweet.created_at.replace(tzinfo=timezone.utc),
                        'likes_count': tweet.favorite_count,
                        'comments_count': tweet.reply_count if hasattr(tweet, 'reply_count') else 0,
                        'retweets_count': tweet.retweet_count,
                        'raw_data': json.dumps({
                            'tweet_id': tweet.id,
                            'user_id': tweet.user.id,
                            'screen_name': tweet.user.screen_name,
                            'media_urls': media_urls,
                            'hashtags': [tag['text'] for tag in tweet.entities.get('hashtags', [])],
                            'mentions': [mention['screen_name'] for mention in tweet.entities.get('user_mentions', [])],
                            'method': 'api'
                        })
                    }
                    
                    posts.append(post_data)
                    
                except Exception as e:
                    logging.error(f"Error processing tweet {tweet.id}: {e}")
                    continue
            
            logging.info(f"Successfully scraped {len(posts)} Twitter posts for @{username}")
            
        except tweepy.TweepyException as e:
            logging.error(f"Twitter API error for @{username}: {e}")
        except Exception as e:
            logging.error(f"Error scraping Twitter for @{username}: {e}")
        
        return posts
    
    async def scrape_user_posts_playwright(self, username, max_posts=10):
        """Scrape posts from Twitter/X using Playwright"""
        posts = []
        
        try:
            username = username.lstrip('@')
            logging.info(f"Scraping Twitter posts for @{username} using Playwright")
            
            # Navigate to user profile
            await self.page.goto(f'https://x.com/{username}', wait_until='networkidle')
            
            # Check if profile exists
            if await self.page.locator('text=This account doesn\'t exist').count() > 0:
                logging.error(f"Twitter profile @{username} does not exist")
                return posts
            
            # Check if profile is suspended
            if await self.page.locator('text=Account suspended').count() > 0:
                logging.error(f"Twitter profile @{username} is suspended")
                return posts
            
            # Wait for tweets to load
            await self.page.wait_for_selector('[data-testid="tweet"]', timeout=15000)
            
            # Scroll and collect tweets
            collected_tweets = set()
            scroll_attempts = 0
            max_scroll_attempts = 10
            
            while len(collected_tweets) < max_posts and scroll_attempts < max_scroll_attempts:
                # Find all tweet elements
                tweet_elements = await self.page.locator('[data-testid="tweet"]').all()
                
                for tweet_element in tweet_elements:
                    if len(collected_tweets) >= max_posts:
                        break
                    
                    try:
                        # Extract tweet data
                        tweet_data = await self.extract_tweet_data(tweet_element, username)
                        if tweet_data and tweet_data['post_id'] not in [t['post_id'] for t in collected_tweets]:
                            collected_tweets.add(tweet_data['post_id'])
                            posts.append(tweet_data)
                            
                    except Exception as e:
                        logging.error(f"Error extracting tweet data: {e}")
                        continue
                
                # Scroll down to load more tweets
                await self.page.evaluate('window.scrollTo(0, document.body.scrollHeight)')
                await self.page.wait_for_timeout(random.randint(2000, 4000))
                scroll_attempts += 1
            
            logging.info(f"Successfully scraped {len(posts)} Twitter posts for @{username}")
            
        except Exception as e:
            logging.error(f"Error scraping Twitter for @{username}: {e}")
        
        return posts
    
    async def extract_tweet_data(self, tweet_element, username):
        """Extract data from a single tweet element"""
        try:
            # Extract tweet text
            content = ""
            try:
                text_element = tweet_element.locator('[data-testid="tweetText"]').first
                if await text_element.count() > 0:
                    content = await text_element.inner_text()
            except:
                pass
            
            # Extract tweet URL/ID
            tweet_id = None
            post_url = None
            try:
                time_element = tweet_element.locator('time').first
                if await time_element.count() > 0:
                    parent_link = time_element.locator('..').first
                    href = await parent_link.get_attribute('href')
                    if href:
                        # Extract tweet ID from URL
                        id_match = re.search(r'/status/(\d+)', href)
                        if id_match:
                            tweet_id = id_match.group(1)
                            post_url = f"https://x.com{href}"
            except:
                pass
            
            if not tweet_id:
                return None
            
            # Extract image URL
            image_url = None
            try:
                img_element = tweet_element.locator('img[src*="pbs.twimg.com"]').first
                if await img_element.count() > 0:
                    image_url = await img_element.get_attribute('src')
            except:
                pass
            
            # Extract engagement metrics
            likes_count = 0
            retweets_count = 0
            comments_count = 0
            
            try:
                # Look for engagement buttons
                engagement_elements = await tweet_element.locator('[role="group"] [role="button"]').all()
                
                for element in engagement_elements:
                    aria_label = await element.get_attribute('aria-label')
                    if aria_label:
                        # Extract numbers from aria-label
                        if 'like' in aria_label.lower():
                            likes_match = re.search(r'(\d+)', aria_label)
                            if likes_match:
                                likes_count = int(likes_match.group(1))
                        elif 'retweet' in aria_label.lower():
                            retweets_match = re.search(r'(\d+)', aria_label)
                            if retweets_match:
                                retweets_count = int(retweets_match.group(1))
                        elif 'repl' in aria_label.lower():
                            replies_match = re.search(r'(\d+)', aria_label)
                            if replies_match:
                                comments_count = int(replies_match.group(1))
                                
            except Exception as e:
                logging.warning(f"Could not extract engagement metrics: {e}")
            
            # Extract post date
            posted_at = datetime.now(timezone.utc)
            try:
                time_element = tweet_element.locator('time').first
                if await time_element.count() > 0:
                    datetime_attr = await time_element.get_attribute('datetime')
                    if datetime_attr:
                        posted_at = datetime.fromisoformat(datetime_attr.replace('Z', '+00:00'))
            except:
                pass
            
            post_data = {
                'post_id': f"x_{tweet_id}",
                'content': content,
                'image_url': image_url,
                'post_url': post_url,
                'posted_at': posted_at,
                'likes_count': likes_count,
                'comments_count': comments_count,
                'retweets_count': retweets_count,
                'raw_data': json.dumps({
                    'tweet_id': tweet_id,
                    'username': username,
                    'scraped_at': datetime.now().isoformat(),
                    'method': 'playwright'
                })
            }
            
            return post_data
            
        except Exception as e:
            logging.error(f"Error extracting tweet data: {e}")
            return None
    
    async def scrape_user_posts_with_setup(self, username, max_posts=10):
        """Main method that handles browser setup and cleanup"""
        posts = []
        
        # Try API first if available
        if self.api:
            posts = self.scrape_user_posts_api(username, max_posts)
            if posts:
                return posts
        
        # Fallback to Playwright scraping
        try:
            # Setup browser
            if not await self.setup_browser():
                return posts
            
            # Scrape posts
            posts = await self.scrape_user_posts_playwright(username, max_posts)
            
        except Exception as e:
            logging.error(f"Error in Twitter scraping: {e}")
        finally:
            # Always cleanup
            await self.close_browser()
        
        return posts

# Synchronous wrapper for easier integration
def scrape_twitter_posts(username, max_posts=10):
    """Synchronous wrapper for Twitter scraping"""
    scraper = TwitterScraper()
    return asyncio.run(scraper.scrape_user_posts_with_setup(username, max_posts))