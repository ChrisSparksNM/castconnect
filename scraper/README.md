# Social Media Scraper for TV Shows & Actors

A Python-based scraper that fetches Instagram and Twitter/X posts from TV show actors and stores them in your Laravel database for display in the social media feeds.

## Features

- 🎭 **Actor-based scraping** - Automatically scrapes posts from all actors in your database
- 📸 **Instagram support** - Scrapes posts, images, captions, and engagement metrics
- 𝕏 **Twitter/X support** - Scrapes tweets, images, and engagement metrics  
- 🎯 **Smart targeting** - Only scrapes actors with social media handles
- 🔄 **Duplicate prevention** - Avoids inserting duplicate posts
- 📊 **Database integration** - Directly inserts into Laravel's social_media_posts table
- 🛡️ **Rate limiting** - Respectful delays to avoid being blocked
- 📝 **Comprehensive logging** - Detailed logs for monitoring and debugging
- 🧹 **Cleanup functionality** - Removes old posts to keep database clean

## Requirements

- Python 3.8+
- MySQL database (your Laravel app's database)
- Playwright (for web scraping)
- Optional: Twitter API credentials (for better Twitter scraping)
- Optional: Instagram credentials (for private account access)

## Installation

1. **Clone or download the scraper files to a `scraper/` directory**

2. **Run the setup script:**
   ```bash
   cd scraper
   python setup.py
   ```

3. **Configure your environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

4. **Test the database connection:**
   ```bash
   python main.py --test-db
   ```

## Configuration

Edit the `.env` file with your settings:

```env
# Database Configuration (from your Laravel app)
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tv_actors_db
DB_USERNAME=tv_actors_user
DB_PASSWORD=your_secure_password

# Twitter API Credentials (Optional - for better Twitter scraping)
TWITTER_BEARER_TOKEN=your_twitter_bearer_token
TWITTER_API_KEY=your_api_key
TWITTER_API_SECRET=your_api_secret
TWITTER_ACCESS_TOKEN=your_access_token
TWITTER_ACCESS_TOKEN_SECRET=your_access_token_secret

# Instagram Credentials (Optional - for private account access)
INSTAGRAM_USERNAME=your_instagram_username
INSTAGRAM_PASSWORD=your_instagram_password

# Scraping Configuration
MAX_POSTS_PER_ACTOR=10
SCRAPE_DELAY_SECONDS=2
USE_HEADLESS_BROWSER=true
```

## Usage

### Basic Commands

```bash
# Scrape all actors with social media handles
python main.py

# Scrape a specific actor by ID
python main.py --actor 1

# Test database connection
python main.py --test-db

# Clean up old posts (older than 90 days)
python main.py --cleanup 90
```

### Example Output

```
🚀 Starting social media scraping for all actors
Found 12 actors with social media handles

📺 Processing actor 1/12: Bryan Cranston from Breaking Bad
📸 Scraping Instagram for @bryancranston
✅ Scraped 8 Instagram posts
𝕏 Scraping Twitter/X for @BryanCranston
✅ Scraped 6 Twitter/X posts
📊 Total posts scraped for Bryan Cranston: 14

📺 Processing actor 2/12: Anna Gunn from Breaking Bad
📸 Scraping Instagram for @annagunnofficial
✅ Scraped 5 Instagram posts
...

🎉 Scraping completed!
📊 Total posts scraped: 156
👥 Actors processed: 12
```

## How It Works

1. **Database Connection**: Connects to your Laravel MySQL database
2. **Actor Discovery**: Finds all actors with Instagram or Twitter handles
3. **Instagram Scraping**: Uses Playwright to scrape Instagram posts
4. **Twitter Scraping**: Uses Twitter API (if available) or Playwright
5. **Data Processing**: Extracts post content, images, engagement metrics
6. **Database Storage**: Inserts posts into `social_media_posts` table
7. **Duplicate Prevention**: Checks for existing posts before inserting

## Scraped Data

For each post, the scraper collects:

- **Post ID** - Unique identifier
- **Content** - Post text/caption
- **Image URL** - First image from the post
- **Post URL** - Link to original post
- **Posted Date** - When the post was published
- **Engagement** - Likes, comments, retweets
- **Raw Data** - Additional metadata in JSON format

## Scheduling

To run the scraper automatically, you can set up a cron job:

```bash
# Run every 4 hours
0 */4 * * * cd /path/to/scraper && python main.py >> scraper.log 2>&1

# Clean up old posts weekly
0 2 * * 0 cd /path/to/scraper && python main.py --cleanup 90 >> scraper.log 2>&1
```

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check your `.env` database credentials
   - Ensure MySQL is running and accessible
   - Verify the database and tables exist

2. **Instagram Scraping Issues**
   - Instagram frequently changes their HTML structure
   - Consider adding Instagram credentials for better access
   - Check if accounts are private or blocked

3. **Twitter Scraping Issues**
   - Twitter/X has strict anti-scraping measures
   - API access is recommended for reliable scraping
   - Consider using Twitter API credentials

4. **Browser Issues**
   - Run `playwright install chromium` to reinstall browsers
   - Check if system has required dependencies
   - Try running with `USE_HEADLESS_BROWSER=false` for debugging

### Logs

Check `scraper.log` for detailed information about:
- Scraping progress
- Errors and warnings
- Database operations
- Performance metrics

## API Integration

### Twitter API Setup

1. Create a Twitter Developer account
2. Create a new app and get API keys
3. Add credentials to `.env` file
4. The scraper will automatically use API when available

### Instagram API

Instagram's official API has limited access. The scraper uses web scraping by default, but you can:
1. Add Instagram login credentials for better access
2. Consider Instagram Basic Display API for business accounts

## Performance

- **Speed**: ~2-3 seconds per actor (with delays)
- **Memory**: ~50-100MB during operation
- **Storage**: ~1KB per post in database
- **Rate Limits**: Built-in delays to respect platform limits

## Security

- Uses headless browsers to avoid detection
- Randomized user agents and delays
- Respects robots.txt and rate limits
- Secure database connections
- No storage of sensitive credentials in code

## Contributing

To improve the scraper:
1. Update selectors if platforms change their HTML
2. Add new platforms (TikTok, YouTube, etc.)
3. Improve error handling and retry logic
4. Add more engagement metrics
5. Optimize performance and memory usage

## License

This scraper is for educational and personal use. Please respect the terms of service of Instagram and Twitter/X when using this tool.