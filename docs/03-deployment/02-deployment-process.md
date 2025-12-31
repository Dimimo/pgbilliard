# Deployment Process

## Overview

The PG Billiard League uses a simple pull-based deployment process. Changes are deployed directly from the main branch to production.

## Pre-Deployment Checklist

Before deploying:

- [ ] All tests pass locally
- [ ] Code style checks pass (`./vendor/bin/pint --test`)
- [ ] No known critical bugs
- [ ] Database migrations tested
- [ ] Backup taken (automated or manual)

## Standard Deployment

### Step 1: SSH into Server

```bash
ssh pgbilliard@your-server-ip
```

### Step 2: Navigate to Application Directory

```bash
cd /var/www/pgbilliard
```

### Step 3: Enable Maintenance Mode

```bash
php artisan down --message="Updating application" --retry=60
```

This displays a maintenance page to users during deployment.

### Step 4: Pull Latest Changes

```bash
git pull origin main
```

Review the changes pulled:

```bash
git log -5 --oneline
```

### Step 5: Install/Update Dependencies

```bash
# PHP dependencies
composer install --no-dev --optimize-autoloader

# Node dependencies (if package.json changed)
npm ci --production
```

### Step 6: Run Migrations

```bash
php artisan migrate --force
```

The `--force` flag is required in production.

### Step 7: Build Frontend Assets

```bash
npm run build
```

### Step 8: Clear and Rebuild Caches

```bash
# Clear old caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Step 9: Restart Services

```bash
# Restart queue worker
sudo systemctl restart pgbilliard-queue

# Restart Reverb server
sudo systemctl restart pgbilliard-reverb

# Reload PHP-FPM
sudo systemctl reload php8.3-fpm

# Reload Nginx (if config changed)
sudo systemctl reload nginx
```

### Step 10: Disable Maintenance Mode

```bash
php artisan up
```

### Step 11: Verify Deployment

Check that everything works:

```bash
# Check application status
php artisan about

# Check services
sudo systemctl status pgbilliard-queue
sudo systemctl status pgbilliard-reverb

# Check recent logs
tail -f storage/logs/laravel.log
```

Visit the website and test key functionality:

- Homepage loads
- User login works
- Real-time features work
- Database queries execute

## Quick Deployment Script

Create a deployment script for faster deployments:

```bash
#!/bin/bash
# deploy.sh

echo "Starting deployment..."

# Enable maintenance mode
php artisan down --message="Updating application" --retry=60

# Pull changes
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Check if package.json changed
if git diff HEAD@{1} --name-only | grep -q "package.json"; then
    echo "package.json changed, reinstalling Node dependencies..."
    npm ci --production
    npm run build
fi

# Run migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Restart services
sudo systemctl restart pgbilliard-queue
sudo systemctl restart pgbilliard-reverb
sudo systemctl reload php8.3-fpm

# Disable maintenance mode
php artisan up

echo "Deployment complete!"
```

Make it executable:

```bash
chmod +x deploy.sh
```

Run deployment:

```bash
./deploy.sh
```

## Deployment Scenarios

### Deploying Code Changes Only

If only PHP/Blade code changed (no migrations, no asset changes):

```bash
php artisan down
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan optimize
sudo systemctl restart pgbilliard-queue
php artisan up
```

### Deploying Database Changes

If migrations are included:

```bash
php artisan down
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
sudo systemctl restart pgbilliard-queue
php artisan up
```

### Deploying Frontend Changes

If assets changed:

```bash
git pull origin main
npm ci --production
npm run build
sudo systemctl reload nginx
```

Note: Frontend-only changes don't require maintenance mode.

### Deploying Configuration Changes

If config files changed:

```bash
php artisan down
git pull origin main
php artisan config:clear
php artisan config:cache
sudo systemctl reload php8.3-fpm
sudo systemctl restart pgbilliard-queue
sudo systemctl restart pgbilliard-reverb
php artisan up
```

### Deploying Nginx Configuration Changes

If Nginx config changed:

```bash
# Test configuration
sudo nginx -t

# If test passes, reload
sudo systemctl reload nginx
```

## Rollback Procedure

Since there's no versioning, rollback requires reverting commits:

### Step 1: Identify Commit to Rollback To

```bash
git log --oneline -10
```

### Step 2: Revert to Previous Commit

```bash
# Revert to specific commit
git reset --hard <commit-hash>

# Or revert last commit
git reset --hard HEAD~1
```

### Step 3: Force Push (if needed)

**Warning**: Only do this if you're certain!

```bash
git push origin main --force
```

### Step 4: Redeploy

Follow the standard deployment process.

### Alternative: Revert Commit

Instead of reset, create a revert commit:

```bash
git revert <commit-hash>
git push origin main
```

Then deploy normally.

## Zero-Downtime Deployment (Advanced)

For zero-downtime deployments, use a blue-green strategy:

### Setup

1. Create two application directories:
   - `/var/www/pgbilliard-blue`
   - `/var/www/pgbilliard-green`

2. Symlink current:

   ```bash
   ln -s /var/www/pgbilliard-blue /var/www/pgbilliard-current
   ```

3. Point Nginx to `/var/www/pgbilliard-current`

### Deployment

1. Determine inactive environment
2. Deploy to inactive environment
3. Test inactive environment
4. Switch symlink to inactive environment
5. Reload Nginx

This is optional and more complex than needed for this project.

## Monitoring Deployment

### Check Application Logs

```bash
# Real-time logs
tail -f storage/logs/laravel.log

# Errors only
tail -f storage/logs/laravel.log | grep ERROR

# Last 100 lines
tail -n 100 storage/logs/laravel.log
```

### Check Nginx Logs

```bash
# Access log
tail -f /var/log/nginx/pgbilliard-access.log

# Error log
tail -f /var/log/nginx/pgbilliard-error.log
```

### Check Service Status

```bash
# Queue worker
sudo systemctl status pgbilliard-queue

# Reverb server
sudo systemctl status pgbilliard-reverb

# PHP-FPM
sudo systemctl status php8.3-fpm

# Nginx
sudo systemctl status nginx

# Redis
sudo systemctl status redis-server

# MySQL
sudo systemctl status mysql
```

### Check Queue Status

```bash
# View failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry <job-id>

# Retry all failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

### Check Reverb Connections

```bash
# View active WebSocket connections
php artisan reverb:stats
```

## Common Deployment Issues

### Issue: Composer Install Fails

**Symptom**: Dependency conflicts or missing packages

**Solution**:

```bash
# Remove vendor directory
rm -rf vendor

# Clear composer cache
composer clear-cache

# Reinstall
composer install --no-dev --optimize-autoloader
```

### Issue: Migration Fails

**Symptom**: Migration error during deployment

**Solution**:

```bash
# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Fix migration file
# Then run again
php artisan migrate --force
```

### Issue: Assets Not Loading

**Symptom**: 404 errors for CSS/JS files

**Solution**:

```bash
# Rebuild assets
npm run build

# Clear browser cache
# Check Nginx configuration
sudo nginx -t

# Check file permissions
ls -la public/build
```

### Issue: Queue Not Processing

**Symptom**: Jobs stuck in queue

**Solution**:

```bash
# Restart queue worker
sudo systemctl restart pgbilliard-queue

# Check for failed jobs
php artisan queue:failed

# Clear old jobs
php artisan queue:flush

# Monitor queue
php artisan queue:monitor
```

### Issue: WebSocket Not Connecting

**Symptom**: Real-time features not working

**Solution**:

```bash
# Restart Reverb
sudo systemctl restart pgbilliard-reverb

# Check Reverb logs
sudo journalctl -u pgbilliard-reverb -f

# Verify Nginx proxy config
sudo nginx -t

# Test WebSocket connection
wscat -c ws://localhost:8080
```

### Issue: 500 Internal Server Error

**Symptom**: Application returns 500 error

**Solution**:

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check Nginx error logs
tail -f /var/log/nginx/pgbilliard-error.log

# Check PHP-FPM logs
tail -f /var/log/php8.3-fpm.log

# Verify file permissions
sudo chown -R pgbilliard:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Clear and rebuild caches
php artisan optimize:clear
php artisan optimize
```

### Issue: Slow Performance After Deploy

**Symptom**: Application is slower than expected

**Solution**:

```bash
# Enable opcache
sudo nano /etc/php/8.3/fpm/php.ini
# Set: opcache.enable=1

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm

# Check for N+1 queries in logs
# Add eager loading where needed

# Enable query caching in production
```

## Post-Deployment Checklist

After deployment, verify:

- [ ] Homepage loads correctly
- [ ] User authentication works
- [ ] Database queries execute
- [ ] Real-time features work
- [ ] No errors in logs
- [ ] Queue worker processing jobs
- [ ] Scheduled tasks running
- [ ] Email sending works
- [ ] File uploads work
- [ ] Search functionality works

## Automated Deployments (Optional)

For automated deployments, consider using:

### GitHub Actions

Create `.github/workflows/deploy.yml`:

```yaml
name: Deploy

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to Production
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/pgbilliard
            ./deploy.sh
```

### Deploy Webhooks

Create a webhook endpoint that triggers deployment:

```php
// routes/web.php
Route::post('/deploy-webhook', function (Request $request) {
    if ($request->input('secret') !== config('app.deploy_secret')) {
        abort(403);
    }

    Artisan::call('down');
    exec('git pull origin main');
    exec('composer install --no-dev --optimize-autoloader');
    exec('php artisan migrate --force');
    exec('npm ci --production && npm run build');
    Artisan::call('optimize');
    exec('sudo systemctl restart pgbilliard-queue');
    exec('sudo systemctl restart pgbilliard-reverb');
    Artisan::call('up');

    return response()->json(['status' => 'deployed']);
});
```

Configure GitHub/GitLab webhook to call this endpoint on push.

## Next Steps

Proceed to [Maintenance](03-maintenance.md) for ongoing maintenance procedures.
