# Development Guide

This section provides comprehensive documentation for developers working on the Puerto Galera Billiard League application.

## Table of Contents

1. [Getting Started](01-getting-started.md) - Local development setup and prerequisites
2. [Development Workflows](02-workflows.md) - Common development tasks and workflows
3. [Testing](03-testing.md) - Testing strategy, writing tests, and running test suites

## Quick Links

- [Architecture Guide](../01-architecture/README.md)
- [Deployment Guide](../03-deployment/README.md)
- [API Documentation](../04-api/README.md)

## Quick Start

```bash
# Clone the repository
git clone <repository-url>
cd pgbilliard

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Start development servers
php artisan serve
php artisan reverb:start
npm run dev
```

## Development Tools

- **Laravel Debugbar**: Debug toolbar for development
- **Laravel IDE Helper**: IDE autocompletion support
- **Laravel Pint**: Code style fixer
- **Larastan**: Static analysis tool
- **Rector**: Automated code refactoring

## Code Style

The project follows PSR-12 coding standards enforced by Laravel Pint:

```bash
./vendor/bin/pint        # Fix code style issues
./vendor/bin/pint --test # Check without fixing
```

## Contributing

Since this is a hobby project with a single main branch:

1. Pull latest changes: `git pull`
2. Make your changes
3. Test thoroughly
4. Commit with descriptive messages
5. Push to main: `git push`

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)
