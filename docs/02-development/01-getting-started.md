# Getting Started

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.3 or higher**
- **Composer** (latest version)
- **Node.js 18+ and npm**
- **MySQL 8.0+ or MariaDB 10.5+**
- **Redis 6.0+**
- **Git**

### Optional but Recommended

- **Docker** (for Laravel Sail)
- **AWS CLI** (for S3 storage)

## System Requirements

### Required PHP Extensions

The following PHP extensions are required:

- `ext-curl`
- `ext-pdo`
- `ext-zip`
- `ext-mbstring`
- `ext-xml`
- `ext-json`
- `ext-bcmath`
- `ext-gd` or `ext-imagick`

Check your PHP version and extensions:

```bash
php -v
php -m
```

## Installation

### Step 1: Clone the Repository

```bash
git clone <repository-url> pgbilliard
cd pgbilliard
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

This will install all required PHP packages including Laravel and its dependencies.

### Step 3: Install Node Dependencies

```bash
npm install
```

This installs frontend dependencies including Vite, Tailwind CSS, and related tools.

### Step 4: Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Edit `.env` file and configure the following:

#### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgbilliard
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Redis Configuration

```env
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

#### Cache and Queue Configuration

```env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### Broadcasting Configuration

```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http
```

#### AWS S3 Configuration (Optional)

If using AWS S3 for file storage:

```env
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_USE_PATH_STYLE_ENDPOINT=false
```

For local development, you can use the `public` disk instead:

```env
FILESYSTEM_DISK=public
```

#### Mail Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 5: Database Setup

Create the database:

```bash
mysql -u root -p
CREATE DATABASE pgbilliard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Run migrations:

```bash
php artisan migrate
```

Seed the database with sample data:

```bash
php artisan db:seed
```

### Step 6: Storage Setup

Create symbolic link for public storage:

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`.

### Step 7: IDE Helper Generation (Optional)

Generate IDE helper files for better autocompletion:

```bash
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
php artisan ide-helper:meta
```

## Running the Application

### Development Servers

You need to run three separate processes:

#### 1. PHP Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

#### 2. Vite Development Server

```bash
npm run dev
```

This runs the Vite development server with hot module replacement (HMR) for frontend assets.

#### 3. Laravel Reverb (WebSocket Server)

```bash
php artisan reverb:start
```

This starts the WebSocket server for real-time features.

Alternatively, run in debug mode:

```bash
php artisan reverb:start --debug
```

### Queue Worker (Optional)

If you're working with background jobs:

```bash
php artisan queue:work
```

Or use the `queue:listen` command for automatic reloading:

```bash
php artisan queue:listen
```

## Using Laravel Sail (Docker)

Laravel Sail provides a Docker-based development environment.

### Initial Setup with Sail

```bash
# Install dependencies
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Start Sail
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate

# Seed database
./vendor/bin/sail artisan db:seed
```

### Using Sail Commands

Replace `php artisan` with `sail artisan`:

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan queue:work
./vendor/bin/sail npm run dev
```

Create an alias for convenience:

```bash
alias sail='./vendor/bin/sail'
```

Then use:

```bash
sail up -d
sail artisan migrate
sail npm run dev
```

## Verification

Verify your installation by checking:

1. **Application loads**: Visit `http://localhost:8000`
2. **Database connection**: Run `php artisan tinker` and execute `DB::connection()->getPdo();`
3. **Redis connection**: Run `php artisan tinker` and execute `Redis::connection()->ping();`
4. **Assets compile**: Check browser console for errors

## Troubleshooting

### Common Issues

#### "Class 'Redis' not found"

Install PHP Redis extension:

```bash
# Ubuntu/Debian
sudo apt-get install php-redis

# macOS (using Homebrew)
brew install php-redis

# Then restart PHP
```

#### "SQLSTATE[HY000] [2002] Connection refused"

Check if MySQL is running:

```bash
sudo service mysql status
# or
sudo systemctl status mysql
```

Start MySQL if it's not running:

```bash
sudo service mysql start
```

#### Permission Denied on storage directories

Fix permissions:

```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

#### npm install fails

Clear npm cache and try again:

```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

#### Port already in use

Change the port for the development server:

```bash
php artisan serve --port=8001
```

Or for Vite:

```bash
npm run dev -- --port=5174
```

### Debug Mode

Enable debug mode in `.env` for detailed error messages:

```env
APP_DEBUG=true
```

**Important**: Never enable debug mode in production!

### Laravel Debugbar

The Laravel Debugbar is installed for development. Access it by clicking the debug icon at the bottom of the page when `APP_DEBUG=true`.

View:

- SQL queries and execution time
- Route information
- View data
- Session data
- Request/response details

## Development Workflow

Once your environment is set up, proceed to [Development Workflows](02-workflows.md) for common development tasks.

## Additional Resources

- [Laravel Installation Documentation](https://laravel.com/docs/installation)
- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Vite Documentation](https://vitejs.dev/)
