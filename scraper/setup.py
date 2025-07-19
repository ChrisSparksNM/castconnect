#!/usr/bin/env python3
"""
Setup script for Social Media Scraper
Installs dependencies and sets up Playwright browsers
"""

import subprocess
import sys
import os

def run_command(command, description):
    """Run a command and handle errors"""
    print(f"🔧 {description}...")
    try:
        result = subprocess.run(command, shell=True, check=True, capture_output=True, text=True)
        print(f"✅ {description} completed successfully")
        return True
    except subprocess.CalledProcessError as e:
        print(f"❌ {description} failed:")
        print(f"Error: {e.stderr}")
        return False

def main():
    """Main setup function"""
    print("🚀 Setting up Social Media Scraper...")
    
    # Check if Python version is compatible
    if sys.version_info < (3, 8):
        print("❌ Python 3.8 or higher is required")
        sys.exit(1)
    
    print(f"✅ Python version: {sys.version}")
    
    # Install Python dependencies
    if not run_command("pip install -r requirements.txt", "Installing Python dependencies"):
        print("❌ Failed to install Python dependencies")
        sys.exit(1)
    
    # Install Playwright browsers
    if not run_command("playwright install chromium", "Installing Playwright Chromium browser"):
        print("❌ Failed to install Playwright browsers")
        sys.exit(1)
    
    # Install system dependencies for Playwright (Linux)
    if sys.platform.startswith('linux'):
        run_command("playwright install-deps chromium", "Installing system dependencies for Playwright")
    
    # Create .env file if it doesn't exist
    if not os.path.exists('.env'):
        print("📝 Creating .env file from template...")
        try:
            with open('.env.example', 'r') as example_file:
                content = example_file.read()
            
            with open('.env', 'w') as env_file:
                env_file.write(content)
            
            print("✅ .env file created")
            print("⚠️  Please edit .env file with your database credentials and API keys")
        except Exception as e:
            print(f"❌ Failed to create .env file: {e}")
    
    print("\n🎉 Setup completed successfully!")
    print("\n📋 Next steps:")
    print("1. Edit .env file with your database credentials")
    print("2. Optionally add Twitter API credentials for better scraping")
    print("3. Optionally add Instagram credentials for private account access")
    print("4. Run: python main.py --test-db (to test database connection)")
    print("5. Run: python main.py (to start scraping)")
    
    print("\n📖 Usage examples:")
    print("  python main.py                    # Scrape all actors")
    print("  python main.py --actor 1          # Scrape specific actor")
    print("  python main.py --cleanup 90       # Clean up posts older than 90 days")
    print("  python main.py --test-db          # Test database connection")

if __name__ == "__main__":
    main()