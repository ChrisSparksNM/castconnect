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

class InstagramScraper:
    def __init__(self):
        self.ua = UserAgent()
        self.browser = None
        self.context = None
        self.page = None
        
    async def setup_browser(self):
        """Initialize Playwright browser"""
        try:
            playwright = await async_playwright().start()
            
            # Launch browser
            self.browser = await playwright.chromium.launch(
                headless=Config.USE_HEADLESS_BROWSER,
                args=[
                    '--no-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-blink-features=AutomationControlled'
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
            """)
            
            logging.info("Instagram browser setup completed")
            return True
            
        except Exception as e:
            logging.error(f"Error setting up Instagram browser: {e}")
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
            logging.info("Instagram browser closed")
        except Exception as e:
            logging.error(f"Error closing Instagram browser: {e}")
    
    async def login_instagram(self):
        """Login to Instagram if credentials provided"""
        if not Config.INSTAGRAM_USERNAME or not Config.INSTAGRAM_PASSWORD:
            logging.info("No Instagram credentials provided, continuing without login")
            return True
        
        try:
            await self.page.goto('https://www.instagram.com/accounts/login/')
            await self.page.wait_for_load_state('networkidle')
            
            # Accept cookies if present
            try:
                await self.page.click('button:has-text("Accept All")', timeout=3000)
            except:
                pass
            
            # Fill login form
            await self.page.fill('input[name="username"]', Config.INSTAGRAM_USERNAME)
            await self.page.fill('input[name="password"]', Config.INSTAGRAM_PASSWORD)
            
            # Click login button
            await self.page.click('button[type="submit"]')
            await self.page.wait_for_load_state('networkidle')
            
            # Handle "Save Your Login Info" popup
            try:
                await self.page.click('button:has-text("Not Now")', timeout=5000)
            except:
                pass
            
            # Handle "Turn on Notifications" popup
            try:
                await self.page.click('button:has-text("Not Now")', timeout=5000)
            except:
                pass
            
            logging.info("Successfully logged into Instagram")
            return True
            
        except Exception as e:
            logging.error(f"Instagram login failed: {e}")
            return False
    
    async def scrape_user_posts(self, username, max_posts=10):
        """Scrape posts from an Instagram user using Playwright"""
        posts = []
        
        try:
            username = username.lstrip('@')
            logging.info(f"Scraping Instagram posts for @{username}")
            
            # Navigate to user profile
            await self.page.goto(f'https://www.instagram.com/{username}/')
            await self.page.wait_for_load_state('networkidle')
            
            # Check if profile exists
            if await self.page.locator('text=Sorry, this page isn\'t available').count() > 0:
                logging.error(f"Instagram profile @{username} does not exist")
                return posts
            
            # Check if profile is private
            if await self.page.locator('text=This Account is Private').count() > 0:
                logging.error(f"Instagram profile @{username} is private")
                return posts
            
            # Wait for posts to load
            await self.page.wait_for_selector('article', timeout=10000)
            
            # Get all post links
            post_links = []
            scroll_attempts = 0
            max_scroll_attempts = 5
            
            while len(post_links) < max_posts and scroll_attempts < max_scroll_attempts:
                # Find all post links
                links = await self.page.locator('article a[href*="/p/"]').all()
                
                for link in links:
                    href = await link.get_attribute('href')
                    if href and href not in post_links:
                        post_links.append(href)
                
                if len(post_links) >= max_posts:
                    break
                
                # Scroll down to load more posts
                await self.page.evaluate('window.scrollTo(0, document.body.scrollHeight)')
                await self.page.wait_for_timeout(2000)
                scroll_attempts += 1
            
            # Limit to max_posts
            post_links = post_links[:max_posts]
            
            # Scrape each post
            for i, post_link in enumerate(post_links):
                try:
                    logging.info(f"Scraping post {i+1}/{len(post_links)}: {post_link}")
                    
                    # Navigate to post
                    await self.page.goto(f'https://www.instagram.com{post_link}')
                    await self.page.wait_for_load_state('networkidle')
                    
                    # Extract post data
                    post_data = await self.extract_post_data(post_link)
                    if post_data:
                        posts.append(post_data)
                    
                    # Add delay between requests
                    await self.page.wait_for_timeout(random.randint(2000, 4000))
                    
                except Exception as e:
                    logging.error(f"Error scraping post {post_link}: {e}")
                    continue
            
            logging.info(f"Successfully scraped {len(posts)} Instagram posts for @{username}")
            
        except Exception as e:
            logging.error(f"Error scraping Instagram for @{username}: {e}")
        
        return posts
    
    async def extract_post_data(self, post_link):
        """Extract data from a single Instagram post"""
        try:
            # Extract shortcode from URL
            shortcode_match = re.search(r'/p/([^/]+)/', post_link)
            if not shortcode_match:
                return None
            
            shortcode = shortcode_match.group(1)
            
            # Wait for post content to load
            await self.page.wait_for_selector('article', timeout=10000)
            
            # Extract caption/content
            content = ""
            try:
                caption_element = await self.page.locator('article h1').first
                if await caption_element.count() > 0:
                    content = await caption_element.inner_text()
            except:
                pass
            
            # Extract image URL
            image_url = None
            try:
                img_element = await self.page.locator('article img').first
                if await img_element.count() > 0:
                    image_url = await img_element.get_attribute('src')
            except:
                pass
            
            # Extract engagement metrics
            likes_count = 0
            comments_count = 0
            
            try:
                # Look for likes count
                likes_elements = await self.page.locator('section span:has-text("likes")').all()
                for element in likes_elements:
                    text = await element.inner_text()
                    likes_match = re.search(r'([\d,]+)\s*likes?', text.replace(',', ''))
                    if likes_match:
                        likes_count = int(likes_match.group(1).replace(',', ''))
                        break
                
                # Look for comments count
                comments_elements = await self.page.locator('section span:has-text("comments")').all()
                for element in comments_elements:
                    text = await element.inner_text()
                    comments_match = re.search(r'([\d,]+)\s*comments?', text.replace(',', ''))
                    if comments_match:
                        comments_count = int(comments_match.group(1).replace(',', ''))
                        break
                        
            except Exception as e:
                logging.warning(f"Could not extract engagement metrics: {e}")
            
            # Extract post date
            posted_at = datetime.now(timezone.utc)
            try:
                time_element = await self.page.locator('time').first
                if await time_element.count() > 0:
                    datetime_attr = await time_element.get_attribute('datetime')
                    if datetime_attr:
                        posted_at = datetime.fromisoformat(datetime_attr.replace('Z', '+00:00'))
            except:
                pass
            
            post_data = {
                'post_id': f"ig_{shortcode}",
                'content': content,
                'image_url': image_url,
                'post_url': f"https://instagram.com/p/{shortcode}",
                'posted_at': posted_at,
                'likes_count': likes_count,
                'comments_count': comments_count,
                'raw_data': json.dumps({
                    'shortcode': shortcode,
                    'scraped_at': datetime.now().isoformat(),
                    'method': 'playwright'
                })
            }
            
            return post_data
            
        except Exception as e:
            logging.error(f"Error extracting post data: {e}")
            return None
    
    async def scrape_user_posts_with_setup(self, username, max_posts=10):
        """Main method that handles browser setup and cleanup"""
        posts = []
        
        try:
            # Setup browser
            if not await self.setup_browser():
                return posts
            
            # Login if credentials provided
            await self.login_instagram()
            
            # Scrape posts
            posts = await self.scrape_user_posts(username, max_posts)
            
        except Exception as e:
            logging.error(f"Error in Instagram scraping: {e}")
        finally:
            # Always cleanup
            await self.close_browser()
        
        return posts

# Synchronous wrapper for easier integration
def scrape_instagram_posts(username, max_posts=10):
    """Synchronous wrapper for Instagram scraping"""
    scraper = InstagramScraper()
    return asyncio.run(scraper.scrape_user_posts_with_setup(username, max_posts))