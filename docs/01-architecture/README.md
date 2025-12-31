# Architecture

This section provides comprehensive documentation about the Puerto Galera Billiard League application architecture.

## Table of Contents

1. [Overview](01-overview.md) - High-level system architecture and technology stack
2. [Patterns](02-patterns.md) - Design patterns and architectural decisions
3. [Data Layer](03-data-layer.md) - Database schema, models, and relationships

## Quick Links

- [Development Guide](../02-development/README.md)
- [Deployment Guide](../03-deployment/README.md)
- [API Documentation](../04-api/README.md)

## Overview

The PG Billiard League is a Laravel-based web application designed to manage billiard league operations, including team management, player statistics, game scheduling, and real-time score updates.

### Key Features

- Team and player management
- Game scheduling and scoring
- Real-time updates using Laravel Reverb
- Forum and chat functionality
- Admin panel
- PWA support

### Technology Stack

- **Framework**: Laravel 12
- **Frontend**: Livewire 3, Volt, Tailwind CSS
- **Real-time**: Laravel Reverb, Ably
- **Database**: MySQL/MariaDB
- **Storage**: AWS S3 (via Flysystem)
- **Cache**: Redis (via Predis)
- **Authentication**: Laravel Breeze, Sanctum
