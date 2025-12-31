# Production Setup

## Server Requirements

### Hardware Requirements

**Minimum:**

- 2 CPU cores
- 4 GB RAM
- 20 GB storage (SSD recommended)
- 10 Mbps network connection

**Recommended:**

- 4 CPU cores
- 8 GB RAM
- 50 GB SSD storage
- 100 Mbps network connection

### Software Requirements

- **Operating System**: Ubuntu 22.04 LTS or 24.04 LTS (recommended)
- **PHP**: 8.3 or higher
- **MySQL**: 8.0+ or MariaDB 10.5+
- **Redis**: 6.0+
- **Nginx**: Latest stable or Apache 2.4+
- **Node.js**: 18+ LTS
- **Composer**: 2.x
- **Git**: 2.x

## Initial Server Setup

### 1. Update System Packages

```bash
sudo apt update
sudo apt upgrade -y
```

### 2. Install PHP 8.3 and Extensions

```bash
# Add PHP repository
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Install PHP and required extensions
sudo apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-mysql \
    php8.3-redis php8.3-curl php8.3-mbstring php8.3-xml \
    php8.3-zip php8.3-gd php8.3-bcmath php8.3-intl

# Verify installation
php -v
php -m
```

### 3. Install MySQL

```bash
# Install MySQL
sudo apt install -y mysql-server

# Secure installation
sudo mysql_secure_installation

# Create database
sudo mysql -u root -p
```

In MySQL prompt:

```sql
CREATE DATABASE pgbilliard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'pgbilliard'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON pgbilliard.* TO 'pgbilliard'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Install Redis

```bash
# Install Redis
sudo apt install -y redis-server

# Configure Redis
sudo nano /etc/redis/redis.conf

# Change the following:
# supervised no -> supervised systemd
# bind 127.0.0.1 ::1

# Start Redis
sudo systemctl enable redis-server
sudo systemctl start redis-server

# Verify
redis-cli ping  # Should return PONG
```

### 5. Install Nginx

```bash
# Install Nginx
sudo apt install -y nginx

# Enable and start
sudo systemctl enable nginx
sudo systemctl start nginx

# Verify
curl http://localhost  # Should show Nginx welcome page
```

### 6. Install Composer

```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify
composer --version
```

### 7. Install Node.js and npm

```bash
# Install Node.js 20 LTS
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Verify
node -v
npm -v
```

## Application Deployment

### 1. Create Application User

```bash
# Create user for running the application
sudo adduser pgbilliard --disabled-password --gecos ""

# Add to www-data group
sudo usermod -a -G www-data pgbilliard
```

### 2. Setup Application Directory

```bash
# Create directory
sudo mkdir -p /var/www/pgbilliard
sudo chown pgbilliard:www-data /var/www/pgbilliard
sudo chmod 755 /var/www/pgbilliard
```

### 3. Clone Repository

```bash
# Switch to application user
sudo su - pgbilliard

# Navigate to directory
cd /var/www/pgbilliard

# Clone repository
git clone <repository-url> .
```

### 4. Install Dependencies

```bash
# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies
npm ci --production

# Build assets
npm run build
```

### 5. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Edit environment file
nano .env
```

Configure the following in `.env`:

```env
APP_NAME="PG Billiard League"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=Asia/Manila
APP_URL=https://www.pgbilliard.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgbilliard
DB_USERNAME=pgbilliard
DB_PASSWORD=your_secure_password

BROADCAST_CONNECTION=reverb
CACHE_STORE=redis
FILESYSTEM_DISK=s3
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@pgbilliard.com"

REVERB_APP_ID=your_app_id
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret
REVERB_HOST="www.pgbilliard.com"
REVERB_PORT=8080
REVERB_SCHEME=https
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Run Migrations

```bash
php artisan migrate --force
```

### 8. Seed Database (Optional)

```bash
php artisan db:seed
```

### 9. Setup Storage

```bash
# Create storage link
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
```

### 10. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Nginx Configuration

### 1. Create Nginx Configuration

```bash
sudo nano /etc/nginx/sites-available/pgbilliard
```

Add the following configuration:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name www.pgbilliard.com pgbilliard.com;

    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name www.pgbilliard.com;

    root /var/www/pgbilliard/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/www.pgbilliard.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/www.pgbilliard.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;

    # Logging
    access_log /var/log/nginx/pgbilliard-access.log;
    error_log /var/log/nginx/pgbilliard-error.log;

    # Character Set
    charset utf-8;

    # Disable access to hidden files
    location ~ /\.(?!well-known).* {
        deny all;
    }

    # PHP handling
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # WebSocket proxy for Laravel Reverb
    location /reverb {
        proxy_pass http://127.0.0.1:8080;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }

    # Static file handling
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Deny access to sensitive files
    location ~ /\.(env|git|htaccess) {
        deny all;
    }
}
```

### 2. Enable Site

```bash
# Create symbolic link
sudo ln -s /etc/nginx/sites-available/pgbilliard /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

## SSL Certificate

### Using Let's Encrypt

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d www.pgbilliard.com -d pgbilliard.com

# Test auto-renewal
sudo certbot renew --dry-run
```

## Systemd Services

### Laravel Queue Worker

Create `/etc/systemd/system/pgbilliard-queue.service`:

```ini
[Unit]
Description=PG Billiard Queue Worker
After=network.target

[Service]
Type=simple
User=pgbilliard
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/pgbilliard/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

### Laravel Reverb (WebSocket Server)

Create `/etc/systemd/system/pgbilliard-reverb.service`:

```ini
[Unit]
Description=PG Billiard Reverb Server
After=network.target

[Service]
Type=simple
User=pgbilliard
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/pgbilliard/artisan reverb:start

[Install]
WantedBy=multi-user.target
```

### Enable and Start Services

```bash
# Reload systemd
sudo systemctl daemon-reload

# Enable services
sudo systemctl enable pgbilliard-queue
sudo systemctl enable pgbilliard-reverb

# Start services
sudo systemctl start pgbilliard-queue
sudo systemctl start pgbilliard-reverb

# Check status
sudo systemctl status pgbilliard-queue
sudo systemctl status pgbilliard-reverb
```

## Scheduled Tasks

Add to crontab:

```bash
# Edit crontab for pgbilliard user
sudo crontab -u pgbilliard -e

# Add Laravel scheduler
* * * * * cd /var/www/pgbilliard && php artisan schedule:run >> /dev/null 2>&1
```

## File Permissions

Set correct permissions:

```bash
sudo chown -R pgbilliard:www-data /var/www/pgbilliard
sudo find /var/www/pgbilliard -type f -exec chmod 644 {} \;
sudo find /var/www/pgbilliard -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/pgbilliard/storage
sudo chmod -R 775 /var/www/pgbilliard/bootstrap/cache
```

## Firewall Configuration

```bash
# Install UFW
sudo apt install -y ufw

# Allow SSH
sudo ufw allow 22/tcp

# Allow HTTP and HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable

# Check status
sudo ufw status
```

## Verification

After setup, verify:

1. **Website accessible**: Visit `https://www.pgbilliard.com`
2. **SSL working**: Check for padlock in browser
3. **Database connection**: Run `php artisan tinker` and execute `DB::connection()->getPdo();`
4. **Redis connection**: Run `php artisan tinker` and execute `Redis::connection()->ping();`
5. **Queue worker running**: Check `sudo systemctl status pgbilliard-queue`
6. **Reverb running**: Check `sudo systemctl status pgbilliard-reverb`
7. **WebSocket connection**: Test real-time features

## Next Steps

Proceed to [Deployment Process](02-deployment-process.md) for ongoing deployment procedures.
