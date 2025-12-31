# Maintenance

## Overview

This document covers ongoing maintenance tasks for the Puerto Galera Billiard League application.

## Daily Maintenance

### Monitor Application Logs

Check for errors and warnings:

```bash
# View today's errors
grep "ERROR" storage/logs/laravel-$(date +%Y-%m-%d).log

# Monitor in real-time
tail -f storage/logs/laravel.log | grep -E "ERROR|WARNING"
```

### Check Service Status

```bash
# Check all services
sudo systemctl status pgbilliard-queue
sudo systemctl status pgbilliard-reverb
sudo systemctl status php8.3-fpm
sudo systemctl status nginx
sudo systemctl status redis-server
sudo systemctl status mysql
```

### Monitor Queue

```bash
# Check for failed jobs
php artisan queue:failed

# View queue stats
php artisan queue:monitor
```

## Weekly Maintenance

### Review Application Logs

```bash
# Find most common errors
grep "ERROR" storage/logs/*.log | cut -d: -f3 | sort | uniq -c | sort -rn | head -20

# Check for slow queries
grep "Slow query" /var/log/mysql/mysql-slow.log
```

### Clear Old Logs

```bash
# Remove logs older than 30 days
find storage/logs -name "*.log" -mtime +30 -delete

# Rotate logs manually if needed
php artisan log:clear
```

### Check Disk Space

```bash
# Check disk usage
df -h

# Find large files
du -sh /var/www/pgbilliard/* | sort -rh | head -10

# Clear old cache files
php artisan cache:clear
php artisan view:clear
```

### Database Optimization

```bash
# Optimize tables
php artisan db:optimize

# Or directly in MySQL
mysql -u pgbilliard -p pgbilliard -e "OPTIMIZE TABLE teams, players, games;"
```

## Monthly Maintenance

### Backup Database

Automated backups should run daily, but verify:

```bash
# Run manual backup
php artisan backup:run

# List backups
php artisan backup:list

# Check backup size
du -sh storage/app/backups/*
```

### Update Dependencies

Check for security updates:

```bash
# Check PHP packages
composer outdated

# Update dependencies
composer update --no-dev

# Check Node packages
npm outdated

# Update Node packages
npm update
```

After updates, test thoroughly before deploying.

### Clean Up Database

Remove soft-deleted records older than 90 days:

```bash
php artisan model:prune
```

Or create a custom command:

```php
// app/Console/Commands/CleanupSoftDeletes.php
Artisan::command('cleanup:soft-deletes', function () {
    $days = 90;

    Team::onlyTrashed()->where('deleted_at', '<', now()->subDays($days))->forceDelete();
    Player::onlyTrashed()->where('deleted_at', '<', now()->subDays($days))->forceDelete();
    Game::onlyTrashed()->where('deleted_at', '<', now()->subDays($days))->forceDelete();

    $this->info("Soft-deleted records older than {$days} days have been permanently removed.");
});
```

Run it:

```bash
php artisan cleanup:soft-deletes
```

### Review and Clean Failed Jobs

```bash
# Review failed jobs
php artisan queue:failed

# Retry all failed jobs
php artisan queue:retry all

# Or flush old failed jobs
php artisan queue:flush
```

### SSL Certificate Renewal

Let's Encrypt certificates auto-renew, but verify:

```bash
# Test renewal
sudo certbot renew --dry-run

# Check certificate expiry
sudo certbot certificates
```

## Quarterly Maintenance

### Security Updates

```bash
# Update system packages
sudo apt update
sudo apt upgrade -y

# Update PHP
sudo apt install -y php8.3

# Restart services after updates
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx
```

### Performance Audit

Review application performance:

```bash
# Check slow database queries
sudo nano /var/log/mysql/mysql-slow.log

# Profile application with Laravel Telescope (if installed)
php artisan telescope:prune

# Check Redis memory usage
redis-cli info memory
```

### Code Quality Review

```bash
# Run static analysis
./vendor/bin/phpstan analyse

# Check code style
./vendor/bin/pint --test

# Run all tests
php artisan test
```

## Backup and Recovery

### Automated Backups

The application uses `spatie/laravel-backup` for automated backups.

Configure in `config/backup.php`:

```php
'backup' => [
    'name' => env('APP_NAME', 'pgbilliard'),
    'source' => [
        'files' => [
            'include' => [
                base_path(),
            ],
            'exclude' => [
                base_path('vendor'),
                base_path('node_modules'),
            ],
        ],
        'databases' => ['mysql'],
    ],
    'destination' => [
        'disks' => ['s3'],
    ],
],
```

Schedule in `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('backup:run')->daily()->at('02:00');
    $schedule->command('backup:clean')->daily()->at('03:00');
}
```

### Manual Backup

```bash
# Backup database
php artisan backup:run --only-db

# Backup files
php artisan backup:run --only-files

# Full backup
php artisan backup:run
```

### Restore from Backup

#### Database Restore

```bash
# Download backup from S3
aws s3 cp s3://your-bucket/backups/latest.zip ./backup.zip

# Extract
unzip backup.zip

# Restore database
mysql -u pgbilliard -p pgbilliard < backup/db-dumps/mysql-pgbilliard.sql
```

#### File Restore

```bash
# Extract files from backup
tar -xzf backup.zip -C /var/www/pgbilliard

# Set permissions
sudo chown -R pgbilliard:www-data /var/www/pgbilliard
sudo chmod -R 775 storage bootstrap/cache
```

### Disaster Recovery

In case of complete server failure:

1. **Provision new server** following [Production Setup](01-production-setup.md)
2. **Restore database** from latest backup
3. **Clone repository** and configure `.env`
4. **Restore uploaded files** from S3 (if not using S3 for primary storage)
5. **Run migrations** to ensure schema is current
6. **Test thoroughly** before switching DNS

## Monitoring and Alerts

### Application Monitoring

Consider implementing:

- **Error tracking**: Sentry, Bugsnag, or Laravel Flare
- **Performance monitoring**: New Relic, Scout APM, or Blackfire
- **Uptime monitoring**: Pingdom, UptimeRobot, or Oh Dear

### Server Monitoring

Monitor server resources:

```bash
# CPU usage
top

# Memory usage
free -h

# Disk I/O
iostat

# Network connections
netstat -an | grep ESTABLISHED | wc -l
```

### Set Up Alerts

Create alerts for:

- High CPU usage (> 80%)
- High memory usage (> 80%)
- Low disk space (< 10%)
- Queue worker stopped
- Reverb server stopped
- High error rate in logs
- SSL certificate expiry

Example using systemd:

Create `/etc/systemd/system/pgbilliard-alert.service`:

```ini
[Unit]
Description=PG Billiard Alert Service
After=network.target

[Service]
Type=oneshot
ExecStart=/usr/local/bin/check-services.sh

[Install]
WantedBy=multi-user.target
```

Create `/usr/local/bin/check-services.sh`:

```bash
#!/bin/bash

services=("pgbilliard-queue" "pgbilliard-reverb" "php8.3-fpm" "nginx" "mysql" "redis-server")

for service in "${services[@]}"; do
    if ! systemctl is-active --quiet "$service"; then
        echo "$service is down!" | mail -s "Service Alert" admin@pgbilliard.com
    fi
done
```

Schedule with cron:

```bash
# Check every 5 minutes
*/5 * * * * /usr/local/bin/check-services.sh
```

## Database Maintenance

### Optimize Tables

```bash
# Laravel command
php artisan db:optimize

# Or manually in MySQL
mysql -u pgbilliard -p
USE pgbilliard;
OPTIMIZE TABLE teams, players, games, dates, schedules, ranks;
```

### Analyze Tables

```sql
ANALYZE TABLE teams, players, games, dates, schedules, ranks;
```

### Check for Corruption

```sql
CHECK TABLE teams, players, games;
```

### Clean Up Old Data

Archive or delete old data:

```php
// Archive old seasons
Season::where('end_date', '<', now()->subYears(2))
    ->update(['archived' => true]);

// Delete very old soft-deleted records
Team::onlyTrashed()
    ->where('deleted_at', '<', now()->subYears(1))
    ->forceDelete();
```

## Redis Maintenance

### Monitor Redis

```bash
# Connect to Redis CLI
redis-cli

# Get info
INFO

# Check memory usage
INFO memory

# Check connected clients
CLIENT LIST

# Monitor commands in real-time
MONITOR
```

### Clear Redis Cache

```bash
# Clear all cache
php artisan cache:clear

# Or directly in Redis
redis-cli FLUSHDB
```

### Redis Persistence

Ensure Redis persistence is configured:

```bash
# Check Redis config
grep -E "save|appendonly" /etc/redis/redis.conf
```

Should have:

```text
save 900 1
save 300 10
save 60 10000
appendonly yes
```

## Security Maintenance

### Review Access Logs

Check for suspicious activity:

```bash
# Check for unusual access patterns
sudo grep "POST" /var/log/nginx/pgbilliard-access.log | grep -v "200\|201" | tail -50

# Check for SQL injection attempts
sudo grep -i "select\|union\|drop\|insert" /var/log/nginx/pgbilliard-access.log

# Check for XSS attempts
sudo grep -i "<script" /var/log/nginx/pgbilliard-access.log
```

### Update Firewall Rules

```bash
# Review current rules
sudo ufw status

# Block suspicious IPs
sudo ufw deny from <ip-address>
```

### Security Updates

```bash
# Check for security updates
sudo apt update
sudo apt list --upgradable | grep -i security

# Install security updates
sudo apt upgrade -y
```

### Rotate Secrets

Periodically rotate:

- `APP_KEY`
- Database passwords
- API keys
- SSL certificates

### Review User Accounts

```bash
# List admin users
php artisan tinker
User::where('is_admin', true)->get();

# Disable inactive accounts
User::where('last_login_at', '<', now()->subMonths(6))
    ->update(['active' => false]);
```

## Performance Optimization

### Enable OPcache

Verify OPcache is enabled:

```bash
php -i | grep opcache.enable
```

Should show `opcache.enable => On => On`

Configure OPcache in `/etc/php/8.3/fpm/php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

### Database Query Optimization

Identify slow queries:

```bash
# Enable slow query log in MySQL
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
```

Add:

```ini
slow_query_log = 1
slow_query_log_file = /var/log/mysql/mysql-slow.log
long_query_time = 2
```

Review slow queries:

```bash
sudo mysqldumpslow /var/log/mysql/mysql-slow.log
```

### Nginx Caching

Add caching to Nginx config:

```nginx
# Add to server block
location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
}
```

### Redis Memory Optimization

Set maxmemory policy:

```bash
# Edit Redis config
sudo nano /etc/redis/redis.conf
```

Add:

```text
maxmemory 256mb
maxmemory-policy allkeys-lru
```

## Troubleshooting Common Issues

### Application Not Loading

1. Check Nginx: `sudo systemctl status nginx`
2. Check PHP-FPM: `sudo systemctl status php8.3-fpm`
3. Check logs: `tail -f /var/log/nginx/pgbilliard-error.log`
4. Verify file permissions
5. Check `.env` configuration

### Database Connection Issues

1. Check MySQL: `sudo systemctl status mysql`
2. Verify credentials in `.env`
3. Test connection: `php artisan tinker` then `DB::connection()->getPdo();`
4. Check MySQL logs: `tail -f /var/log/mysql/error.log`

### Queue Not Processing

1. Check queue worker: `sudo systemctl status pgbilliard-queue`
2. Check Redis: `redis-cli ping`
3. Restart queue worker: `sudo systemctl restart pgbilliard-queue`
4. Check failed jobs: `php artisan queue:failed`

### Real-time Features Not Working

1. Check Reverb: `sudo systemctl status pgbilliard-reverb`
2. Check WebSocket connection in browser console
3. Verify Nginx proxy configuration
4. Restart Reverb: `sudo systemctl restart pgbilliard-reverb`

## Emergency Procedures

### Site Down

1. Enable maintenance mode: `php artisan down`
2. Investigate issue using logs
3. Apply fix
4. Test thoroughly
5. Disable maintenance mode: `php artisan up`

### Database Corruption

1. Stop application
2. Restore from backup
3. Verify data integrity
4. Restart application

### Security Breach

1. Take site offline immediately
2. Change all passwords and secrets
3. Review access logs
4. Restore from clean backup
5. Update all software
6. Implement additional security measures
7. Notify users if personal data affected

## Documentation Updates

Keep documentation updated:

- Document configuration changes
- Record troubleshooting procedures
- Update deployment notes
- Maintain runbook for common tasks

## Resources

- [Laravel Maintenance](https://laravel.com/docs/deployment#maintenance-mode)
- [MySQL Optimization](https://dev.mysql.com/doc/refman/8.0/en/optimization.html)
- [Nginx Performance](https://www.nginx.com/blog/tuning-nginx/)
- [Redis Administration](https://redis.io/topics/admin)
