#!/usr/bin/env python3
"""
Social Media Scraper for TV Shows & Actors
Scrapes Instagram and Twitter/X posts and stores them in Laravel database
"""

import logging
import sys
import os
import argparse
import time
from datetime import datetime

# Add current directory to Python path
current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, current_dir)

try:
    from database import DatabaseManager
    from instagram_scraper import scrape_instagram_posts
    from twitter_scraper import scrape_twitter_posts
    from config import Config
except ImportError as e:
    print(f"❌ Import error: {e}")
    print(f"📁 Current directory: {current_dir}")
    print(f"📁 Python path: {sys.path}")
    print("💡 Make sure you're running this script from the scraper directory")
    sys.exit(1)

# Setup logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('scraper.log'),
        logging.StreamHandler(sys.stdout)
    ]
)

class SocialMediaScraper:
    def __init__(self):
        self.db = DatabaseManager()
        
    def scrape_all_actors(self):
        """Scrape posts for all actors with social media handles"""
        logging.info("🚀 Starting social media scraping for all actors")
        
        # Connect to database
        if not self.db.connect():
            logging.error("Failed to connect to database")
            return False
        
        try:
            # Get all actors with social media handles
            actors = self.db.get_actors_with_social_media()
            
            if not actors:
                logging.warning("No actors with social media handles found")
                return True
            
            logging.info(f"Found {len(actors)} actors with social media handles")
            
            total_posts_scraped = 0
            
            for i, actor in enumerate(actors, 1):
                logging.info(f"\n📺 Processing actor {i}/{len(actors)}: {actor['name']} from {actor['tv_show_name']}")
                
                posts_for_actor = 0
                
                # Scrape Instagram posts
                if actor['instagram_handle']:
                    logging.info(f"📸 Scraping Instagram for @{actor['instagram_handle']}")
                    try:
                        instagram_posts = scrape_instagram_posts(
                            actor['instagram_handle'], 
                            Config.MAX_POSTS_PER_ACTOR
                        )
                        
                        for post in instagram_posts:
                            post['actor_id'] = actor['id']
                            post['platform'] = 'instagram'
                            
                            if self.db.insert_post(post):
                                posts_for_actor += 1
                                total_posts_scraped += 1
                        
                        logging.info(f"✅ Scraped {len(instagram_posts)} Instagram posts")
                        
                    except Exception as e:
                        logging.error(f"❌ Error scraping Instagram for {actor['name']}: {e}")
                
                # Scrape Twitter/X posts
                if actor['x_handle']:
                    logging.info(f"𝕏 Scraping Twitter/X for @{actor['x_handle']}")
                    try:
                        twitter_posts = scrape_twitter_posts(
                            actor['x_handle'], 
                            Config.MAX_POSTS_PER_ACTOR
                        )
                        
                        for post in twitter_posts:
                            post['actor_id'] = actor['id']
                            post['platform'] = 'x'
                            
                            if self.db.insert_post(post):
                                posts_for_actor += 1
                                total_posts_scraped += 1
                        
                        logging.info(f"✅ Scraped {len(twitter_posts)} Twitter/X posts")
                        
                    except Exception as e:
                        logging.error(f"❌ Error scraping Twitter/X for {actor['name']}: {e}")
                
                logging.info(f"📊 Total posts scraped for {actor['name']}: {posts_for_actor}")
                
                # Add delay between actors to be respectful
                if i < len(actors):
                    logging.info(f"⏳ Waiting {Config.SCRAPE_DELAY_SECONDS} seconds before next actor...")
                    time.sleep(Config.SCRAPE_DELAY_SECONDS)
            
            logging.info(f"\n🎉 Scraping completed!")
            logging.info(f"📊 Total posts scraped: {total_posts_scraped}")
            logging.info(f"👥 Actors processed: {len(actors)}")
            
            return True
            
        except Exception as e:
            logging.error(f"Error in scraping process: {e}")
            return False
        finally:
            self.db.disconnect()
    
    def scrape_single_actor(self, actor_id):
        """Scrape posts for a single actor"""
        logging.info(f"🚀 Starting social media scraping for actor ID: {actor_id}")
        
        # Connect to database
        if not self.db.connect():
            logging.error("Failed to connect to database")
            return False
        
        try:
            # Get specific actor
            actors = self.db.get_actors_with_social_media()
            actor = next((a for a in actors if a['id'] == actor_id), None)
            
            if not actor:
                logging.error(f"Actor with ID {actor_id} not found or has no social media handles")
                return False
            
            logging.info(f"📺 Processing actor: {actor['name']} from {actor['tv_show_name']}")
            
            total_posts_scraped = 0
            
            # Scrape Instagram posts
            if actor['instagram_handle']:
                logging.info(f"📸 Scraping Instagram for @{actor['instagram_handle']}")
                try:
                    instagram_posts = scrape_instagram_posts(
                        actor['instagram_handle'], 
                        Config.MAX_POSTS_PER_ACTOR
                    )
                    
                    for post in instagram_posts:
                        post['actor_id'] = actor['id']
                        post['platform'] = 'instagram'
                        
                        if self.db.insert_post(post):
                            total_posts_scraped += 1
                    
                    logging.info(f"✅ Scraped {len(instagram_posts)} Instagram posts")
                    
                except Exception as e:
                    logging.error(f"❌ Error scraping Instagram for {actor['name']}: {e}")
            
            # Scrape Twitter/X posts
            if actor['x_handle']:
                logging.info(f"𝕏 Scraping Twitter/X for @{actor['x_handle']}")
                try:
                    twitter_posts = scrape_twitter_posts(
                        actor['x_handle'], 
                        Config.MAX_POSTS_PER_ACTOR
                    )
                    
                    for post in twitter_posts:
                        post['actor_id'] = actor['id']
                        post['platform'] = 'x'
                        
                        if self.db.insert_post(post):
                            total_posts_scraped += 1
                    
                    logging.info(f"✅ Scraped {len(twitter_posts)} Twitter/X posts")
                    
                except Exception as e:
                    logging.error(f"❌ Error scraping Twitter/X for {actor['name']}: {e}")
            
            logging.info(f"🎉 Scraping completed for {actor['name']}")
            logging.info(f"📊 Total posts scraped: {total_posts_scraped}")
            
            return True
            
        except Exception as e:
            logging.error(f"Error in scraping process: {e}")
            return False
        finally:
            self.db.disconnect()
    
    def cleanup_old_posts(self, days=90):
        """Clean up old posts from database"""
        logging.info(f"🧹 Cleaning up posts older than {days} days")
        
        if not self.db.connect():
            logging.error("Failed to connect to database")
            return False
        
        try:
            deleted_count = self.db.cleanup_old_posts(days)
            logging.info(f"✅ Cleaned up {deleted_count} old posts")
            return True
        except Exception as e:
            logging.error(f"Error cleaning up old posts: {e}")
            return False
        finally:
            self.db.disconnect()

def main():
    """Main function with command line argument parsing"""
    parser = argparse.ArgumentParser(description='Social Media Scraper for TV Shows & Actors')
    parser.add_argument('--actor', type=int, help='Scrape posts for specific actor ID')
    parser.add_argument('--cleanup', type=int, help='Clean up posts older than N days', metavar='DAYS')
    parser.add_argument('--test-db', action='store_true', help='Test database connection')
    
    args = parser.parse_args()
    
    scraper = SocialMediaScraper()
    
    if args.test_db:
        logging.info("🔍 Testing database connection...")
        if scraper.db.connect():
            logging.info("✅ Database connection successful")
            actors = scraper.db.get_actors_with_social_media()
            logging.info(f"📊 Found {len(actors)} actors with social media handles")
            scraper.db.disconnect()
        else:
            logging.error("❌ Database connection failed")
        return
    
    if args.cleanup:
        success = scraper.cleanup_old_posts(args.cleanup)
        sys.exit(0 if success else 1)
    
    if args.actor:
        success = scraper.scrape_single_actor(args.actor)
    else:
        success = scraper.scrape_all_actors()
    
    sys.exit(0 if success else 1)

if __name__ == "__main__":
    main()