#!/usr/bin/env python3
"""
Test script to verify all imports and dependencies work correctly
"""

import sys
import os

print("🔍 Testing Python Social Media Scraper imports...")
print(f"📁 Current directory: {os.getcwd()}")
print(f"🐍 Python version: {sys.version}")

# Test basic imports
try:
    import requests
    print("✅ requests imported successfully")
except ImportError as e:
    print(f"❌ requests import failed: {e}")

try:
    from bs4 import BeautifulSoup
    print("✅ beautifulsoup4 imported successfully")
except ImportError as e:
    print(f"❌ beautifulsoup4 import failed: {e}")

try:
    from playwright.async_api import async_playwright
    print("✅ playwright imported successfully")
except ImportError as e:
    print(f"❌ playwright import failed: {e}")

try:
    import mysql.connector
    print("✅ mysql-connector-python imported successfully")
except ImportError as e:
    print(f"❌ mysql-connector-python import failed: {e}")

try:
    from dotenv import load_dotenv
    print("✅ python-dotenv imported successfully")
except ImportError as e:
    print(f"❌ python-dotenv import failed: {e}")

# Test our custom modules
print("\n🔧 Testing custom modules...")

try:
    from config import Config
    print("✅ config module imported successfully")
    print(f"📊 Max posts per actor: {Config.MAX_POSTS_PER_ACTOR}")
except ImportError as e:
    print(f"❌ config module import failed: {e}")
except Exception as e:
    print(f"⚠️ config module imported but has issues: {e}")

try:
    from database import DatabaseManager
    print("✅ database module imported successfully")
    db = DatabaseManager()
    print("✅ DatabaseManager instance created")
except ImportError as e:
    print(f"❌ database module import failed: {e}")
except Exception as e:
    print(f"⚠️ database module imported but has issues: {e}")

try:
    from instagram_scraper import scrape_instagram_posts
    print("✅ instagram_scraper module imported successfully")
except ImportError as e:
    print(f"❌ instagram_scraper module import failed: {e}")
except Exception as e:
    print(f"⚠️ instagram_scraper module imported but has issues: {e}")

try:
    from twitter_scraper import scrape_twitter_posts
    print("✅ twitter_scraper module imported successfully")
except ImportError as e:
    print(f"❌ twitter_scraper module import failed: {e}")
except Exception as e:
    print(f"⚠️ twitter_scraper module imported but has issues: {e}")

print("\n🎉 Import test completed!")
print("\n💡 If you see any ❌ errors above:")
print("   1. Make sure you've installed requirements: pip install -r requirements.txt")
print("   2. Make sure you're in the scraper directory")
print("   3. Make sure all .py files are in the same directory")
print("   4. Check that .env file exists (copy from .env.example)")