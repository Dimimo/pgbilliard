# Puerto Galera Billiard League Documentation

Welcome to the comprehensive documentation for the Puerto Galera Billiard League application.

## Table of Contents

### 1. Architecture

Learn about the system architecture, design patterns, and technical decisions.

- [Overview](01-architecture/README.md)
  - [System Overview](01-architecture/01-overview.md) - High-level architecture and technology stack
  - [Design Patterns](01-architecture/02-patterns.md) - Architectural patterns and decisions
  - [Data Layer](01-architecture/03-data-layer.md) - Database schema and models

### 2. Development

Everything you need to know about developing the application.

- [Overview](02-development/README.md)
  - [Getting Started](02-development/01-getting-started.md) - Local development setup
  - [Development Workflows](02-development/02-workflows.md) - Common development tasks
  - [Testing](02-development/03-testing.md) - Testing strategy and best practices

### 3. Deployment

Production deployment and server configuration.

- [Overview](03-deployment/README.md)
  - [Production Setup](03-deployment/01-production-setup.md) - Server requirements and setup
  - [Deployment Process](03-deployment/02-deployment-process.md) - Deployment procedures
  - [Maintenance](03-deployment/03-maintenance.md) - Ongoing maintenance tasks

### 4. API

API documentation and integration guides.

- [Overview](04-api/README.md) - API endpoints, authentication, and WebSocket events

## Quick Start

### For Developers

New to the project? Start here:

1. Read the [System Overview](01-architecture/01-overview.md) to understand the architecture
2. Follow the [Getting Started Guide](02-development/01-getting-started.md) to set up your local environment
3. Review [Development Workflows](02-development/02-workflows.md) for common tasks
4. Check the [Testing Guide](02-development/03-testing.md) before making changes

### For Deployers

Deploying to production? Follow these steps:

1. Review [Production Setup](03-deployment/01-production-setup.md) for server requirements
2. Follow the [Deployment Process](03-deployment/02-deployment-process.md) step by step
3. Set up [Maintenance](03-deployment/03-maintenance.md) procedures

### For Integrators

Integrating with the API? Start here:

1. Read the [API Overview](04-api/README.md)
2. Review authentication requirements
3. Check available endpoints
4. Test with the interactive API documentation

## Project Overview

The Puerto Galera Billiard League is a Laravel-based web application designed to manage a local billiard league in Puerto Galera, Philippines. The system handles:

- Team and player management
- Game scheduling and scoring
- Real-time score updates
- Team rankings and statistics
- Community features (forum, chat)
- Administrative controls

### Technology Stack

- **Backend**: Laravel 12, PHP 8.3
- **Frontend**: Livewire 3, Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0+
- **Cache/Queue**: Redis 6.0+
- **Real-time**: Laravel Reverb
- **Storage**: AWS S3
- **Testing**: Pest PHP

### Key Features

- **Real-time Updates**: Live score updates via WebSockets
- **Progressive Web App**: Installable mobile experience
- **Responsive Design**: Works on all devices
- **Team Management**: Roster management and team profiles
- **Game Scheduling**: Automated scheduling system
- **Statistics**: Comprehensive player and team statistics
- **Rankings**: Automated ranking calculations
- **Forum & Chat**: Community communication features

## Documentation Standards

This documentation follows these conventions:

- **Numbered Folders**: Content is organized in numbered folders (01-, 02-, etc.) for clear navigation
- **Progressive Detail**: Information flows from high-level overviews to detailed specifics
- **Context Separation**: Related topics are grouped in context folders
- **Cross-References**: Related documents are linked for easy navigation
- **Code Examples**: Real, working examples are provided where applicable

## Contributing to Documentation

To improve this documentation:

1. Edit markdown files in the `docs/` directory
2. Follow the existing structure and style
3. Run `markdownlint docs/**/*.md` to check formatting
4. Submit changes via git

### Documentation Structure

```text
docs/
├── README.md                           # This file
├── 01-architecture/                    # Architecture documentation
│   ├── README.md                       # Architecture overview
│   ├── 01-overview.md                  # System architecture
│   ├── 02-patterns.md                  # Design patterns
│   └── 03-data-layer.md               # Database and models
├── 02-development/                     # Development guides
│   ├── README.md                       # Development overview
│   ├── 01-getting-started.md          # Setup guide
│   ├── 02-workflows.md                # Development workflows
│   └── 03-testing.md                  # Testing guide
├── 03-deployment/                      # Deployment guides
│   ├── README.md                       # Deployment overview
│   ├── 01-production-setup.md         # Production setup
│   ├── 02-deployment-process.md       # Deployment steps
│   └── 03-maintenance.md              # Maintenance procedures
└── 04-api/                            # API documentation
    └── README.md                       # API reference
```

## Getting Help

### Documentation Issues

If you find errors or gaps in this documentation:

- Open an issue on GitHub
- Email: [admin@pgbilliard.com](mailto:admin@pgbilliard.com)

### Application Issues

For application bugs or feature requests:

- Check existing issues on GitHub
- Create a new issue with details
- Email: [admin@pgbilliard.com](mailto:admin@pgbilliard.com)

### Support Channels

- **Email**: [admin@pgbilliard.com](mailto:admin@pgbilliard.com)
- **Website**: [www.pgbilliard.com](https://www.pgbilliard.com)
- **Developer**: [Dimitri Mostrey](mailto:dimitri@puertoparrot.com)

## Additional Resources

### Laravel Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel News](https://laravel-news.com)
- [Laracasts](https://laracasts.com)

### Livewire Resources

- [Livewire Documentation](https://livewire.laravel.com)
- [Livewire Tips](https://livewire-tips.com)

### Frontend Resources

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev)

### Testing Resources

- [Pest PHP Documentation](https://pestphp.com)
- [Laravel Testing](https://laravel.com/docs/testing)

## Version History

This documentation is for the main branch of the application. The application does not use semantic versioning - all changes are deployed directly to the main branch.

## License

The Puerto Galera Billiard League application and documentation are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

**Developed and Maintained By**: [Dimitri Mostrey](mailto:dimitri@puertoparrot.com)

**Built With**: Laravel, Livewire, Tailwind CSS, and other amazing open-source tools.

---

**Last Updated**: 2025-12-31

**Documentation Version**: 1.0
