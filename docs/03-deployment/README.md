# Deployment Guide

This section provides comprehensive documentation for deploying the Puerto Galera Billiard League application to production.

## Table of Contents

1. [Production Setup](01-production-setup.md) - Server requirements and initial setup
2. [Deployment Process](02-deployment-process.md) - Step-by-step deployment instructions
3. [Maintenance](03-maintenance.md) - Ongoing maintenance tasks

## Quick Links

- [Architecture Guide](../01-architecture/README.md)
- [Development Guide](../02-development/README.md)
- [API Documentation](../04-api/README.md)

## Deployment Overview

The application uses a simple, single-branch deployment strategy:

1. **No versioning**: Main branch only
2. **Pull-based deployment**: Use `git pull` to update
3. **Forward-only updates**: No rollback mechanism
4. **Manual deployments**: No CI/CD pipeline

## Production Requirements

- **PHP 8.3+**
- **MySQL 8.0+ or MariaDB 10.5+**
- **Redis 6.0+**
- **Nginx or Apache**
- **Node.js 18+** (for asset compilation)
- **SSL Certificate** (recommended)

## Deployment Strategy

### Single Environment

This application is designed for a single production environment:

- One production server
- No staging environment
- No blue-green deployment
- Direct updates via git pull

### Update Process

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
npm install --production
npm run build
php artisan queue:restart
```

## Server Architecture

```text
┌─────────────────────────────────────────┐
│         Nginx (Web Server)              │
│         - SSL Termination               │
│         - Static File Serving           │
└─────────────┬───────────────────────────┘
              │
              ▼
┌─────────────────────────────────────────┐
│         PHP-FPM                         │
│         - Laravel Application           │
│         - Livewire Components           │
└─────────────┬───────────────────────────┘
              │
        ┌─────┴─────┬────────────┬─────────┐
        │           │            │         │
        ▼           ▼            ▼         ▼
    ┌───────┐  ┌────────┐  ┌────────┐ ┌─────────┐
    │ MySQL │  │ Redis  │  │ Reverb │ │   S3    │
    │  DB   │  │ Cache  │  │  WS    │ │ Storage │
    └───────┘  └────────┘  └────────┘ └─────────┘
```

## Security Considerations

- SSL/TLS encryption required
- Environment variables for secrets
- Regular security updates
- Database backups
- Firewall configuration
- Rate limiting

## Monitoring

Recommended monitoring:

- Server resources (CPU, RAM, disk)
- Application logs
- Error tracking
- Database performance
- WebSocket connections

## Support

For deployment issues, contact [admin@pgbilliard.com](mailto:admin@pgbilliard.com)
