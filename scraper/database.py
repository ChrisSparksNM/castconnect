import mysql.connector
from mysql.connector import Error
import logging
from config import Config
from datetime import datetime

class DatabaseManager:
    def __init__(self):
        self.connection = None
        self.cursor = None
        
    def connect(self):
        """Establish database connection"""
        try:
            self.connection = mysql.connector.connect(
                host=Config.DB_HOST,
                port=Config.DB_PORT,
                database=Config.DB_DATABASE,
                user=Config.DB_USERNAME,
                password=Config.DB_PASSWORD,
                charset='utf8mb4',
                collation='utf8mb4_unicode_ci'
            )
            
            if self.connection.is_connected():
                self.cursor = self.connection.cursor(dictionary=True)
                logging.info("Successfully connected to MySQL database")
                return True
                
        except Error as e:
            logging.error(f"Error connecting to MySQL: {e}")
            return False
    
    def disconnect(self):
        """Close database connection"""
        if self.cursor:
            self.cursor.close()
        if self.connection and self.connection.is_connected():
            self.connection.close()
            logging.info("MySQL connection closed")
    
    def get_actors_with_social_media(self):
        """Get all actors with Instagram or X handles"""
        try:
            query = """
            SELECT a.*, t.name as tv_show_name 
            FROM actors a 
            JOIN tv_shows t ON a.tv_show_id = t.id 
            WHERE a.instagram_handle IS NOT NULL 
            OR a.x_handle IS NOT NULL
            """
            
            self.cursor.execute(query)
            actors = self.cursor.fetchall()
            
            logging.info(f"Found {len(actors)} actors with social media handles")
            return actors
            
        except Error as e:
            logging.error(f"Error fetching actors: {e}")
            return []
    
    def post_exists(self, actor_id, platform, post_id):
        """Check if a post already exists in the database"""
        try:
            query = """
            SELECT id FROM social_media_posts 
            WHERE actor_id = %s AND platform = %s AND post_id = %s
            """
            
            self.cursor.execute(query, (actor_id, platform, post_id))
            result = self.cursor.fetchone()
            
            return result is not None
            
        except Error as e:
            logging.error(f"Error checking if post exists: {e}")
            return False
    
    def insert_post(self, post_data):
        """Insert a new social media post"""
        try:
            # Check if post already exists
            if self.post_exists(post_data['actor_id'], post_data['platform'], post_data['post_id']):
                logging.info(f"Post {post_data['post_id']} already exists, skipping...")
                return False
            
            query = """
            INSERT INTO social_media_posts 
            (actor_id, platform, post_id, content, image_url, post_url, 
             posted_at, likes_count, comments_count, raw_data, created_at, updated_at)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
            """
            
            now = datetime.now()
            values = (
                post_data['actor_id'],
                post_data['platform'],
                post_data['post_id'],
                post_data.get('content'),
                post_data.get('image_url'),
                post_data['post_url'],
                post_data['posted_at'],
                post_data.get('likes_count', 0),
                post_data.get('comments_count', 0),
                post_data.get('raw_data'),
                now,
                now
            )
            
            self.cursor.execute(query, values)
            self.connection.commit()
            
            logging.info(f"Successfully inserted post {post_data['post_id']} for actor {post_data['actor_id']}")
            return True
            
        except Error as e:
            logging.error(f"Error inserting post: {e}")
            self.connection.rollback()
            return False
    
    def update_post_stats(self, post_id, likes_count, comments_count):
        """Update post engagement statistics"""
        try:
            query = """
            UPDATE social_media_posts 
            SET likes_count = %s, comments_count = %s, updated_at = %s
            WHERE post_id = %s
            """
            
            self.cursor.execute(query, (likes_count, comments_count, datetime.now(), post_id))
            self.connection.commit()
            
            logging.info(f"Updated stats for post {post_id}")
            return True
            
        except Error as e:
            logging.error(f"Error updating post stats: {e}")
            return False
    
    def cleanup_old_posts(self, days=90):
        """Remove posts older than specified days"""
        try:
            query = """
            DELETE FROM social_media_posts 
            WHERE posted_at < DATE_SUB(NOW(), INTERVAL %s DAY)
            """
            
            self.cursor.execute(query, (days,))
            deleted_count = self.cursor.rowcount
            self.connection.commit()
            
            logging.info(f"Cleaned up {deleted_count} old posts")
            return deleted_count
            
        except Error as e:
            logging.error(f"Error cleaning up old posts: {e}")
            return 0