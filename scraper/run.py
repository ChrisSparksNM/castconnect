#!/usr/bin/env python3
"""
Simple runner script that ensures proper directory and imports
"""

import os
import sys

def main():
    # Get the directory where this script is located
    script_dir = os.path.dirname(os.path.abspath(__file__))
    
    # Change to the script directory
    os.chdir(script_dir)
    
    # Add script directory to Python path
    sys.path.insert(0, script_dir)
    
    print(f"📁 Working directory: {os.getcwd()}")
    print(f"🐍 Python path includes: {script_dir}")
    
    # Import and run the main scraper
    try:
        from main import main as scraper_main
        scraper_main()
    except ImportError as e:
        print(f"❌ Import error: {e}")
        print("\n🔧 Troubleshooting steps:")
        print("1. Make sure you're in the scraper directory")
        print("2. Run: pip install -r requirements.txt")
        print("3. Run: python test_imports.py")
        print("4. Check that all .py files exist in this directory")
        sys.exit(1)
    except Exception as e:
        print(f"❌ Runtime error: {e}")
        sys.exit(1)

if __name__ == "__main__":
    main()