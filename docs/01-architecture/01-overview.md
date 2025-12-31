# System Overview

## Introduction

The Puerto Galera Billiard League application is a web-based platform designed to manage a local billiard league in Puerto Galera, Philippines. The system handles team management, player statistics, game scheduling, real-time scoring, and community features like forums and chat.

## High-Level Architecture

```text
┌─────────────────────────────────────────────────────────────┐
│                        Client Layer                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Browser    │  │   Mobile     │  │     PWA      │       │
│  │   (Desktop)  │  │   (Mobile)   │  │  (Offline)   │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                    Presentation Layer                       │
│  ┌──────────────────────────────────────────────────┐       │
│  │            Laravel Livewire Components           │       │
│  │  ┌──────────┐ ┌──────────┐ ┌──────────┐          │       │
│  │  │  Teams   │ │  Games   │ │  Forums  │          │       │
│  │  └──────────┘ └──────────┘ └──────────┘          │       │
│  │  ┌──────────┐ ┌──────────┐ ┌──────────┐          │       │
│  │  │ Players  │ │  Admin   │ │   Chat   │          │       │
│  │  └──────────┘ └──────────┘ └──────────┘          │       │
│  └──────────────────────────────────────────────────┘       │
│                         │                                   │
│  ┌──────────────────────────────────────────────────┐       │
│  │           Tailwind CSS + Alpine.js               │       │
│  └──────────────────────────────────────────────────┘       │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                    Application Layer                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │ Controllers  │  │   Services   │  │    Events    │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │    Jobs      │  │  Listeners   │  │  Middleware  │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                      Domain Layer                           │
│  ┌──────────────────────────────────────────────────┐       │
│  │                  Eloquent Models                 │       │
│  │  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐    │       │
│  │  │ User │ │ Team │ │Player│ │ Game │ │Season│    │       │
│  │  └──────┘ └──────┘ └──────┘ └──────┘ └──────┘    │       │
│  │  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐             │       │
│  │  │Event │ │ Date │ │Venue │ │ Rank │             │       │
│  │  └──────┘ └──────┘ └──────┘ └──────┘             │       │
│  └──────────────────────────────────────────────────┘       │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                   Infrastructure Layer                      │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Database   │  │    Cache     │  │   Storage    │       │
│  │    (MySQL)   │  │   (Redis)    │  │   (AWS S3)   │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │  Real-time   │  │    Queue     │  │     Mail     │       │
│  │  (Reverb)    │  │   (Redis)    │  │    (SMTP)    │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
└─────────────────────────────────────────────────────────────┘
```

## Technology Stack

### Backend Framework

- **Laravel 12**: PHP framework providing routing, ORM, authentication, and more
- **PHP 8.3**: Latest PHP version with modern syntax and performance improvements

### Frontend Technologies

- **Livewire 3**: Full-stack framework for building dynamic interfaces without writing JavaScript
- **Volt**: An elegantly crafted functional API for Livewire
- **Tailwind CSS**: Utility-first CSS framework for rapid UI development
- **Alpine.js**: Lightweight JavaScript framework for reactive components

### Real-time Communication

- **Laravel Reverb**: First-party WebSocket server for Laravel
- **Ably**: Cloud-based pub/sub messaging service
- **Broadcasting**: Laravel's event broadcasting system

### Data & Storage

- **MySQL/MariaDB**: Primary database for structured data
- **Redis**: In-memory data structure store for caching and queues
- **AWS S3**: Object storage for files and assets
- **Flysystem**: Filesystem abstraction layer

### Authentication & Security

- **Laravel Breeze**: Minimal authentication scaffolding
- **Laravel Sanctum**: API token authentication
- **Policies**: Authorization logic for models

### Additional Packages

- **Spatie Laravel Backup**: Database and file backup solution
- **Masmerise Livewire Toaster**: Toast notifications for Livewire
- **Wire Elements Modal**: Modal component for Livewire
- **Knuckles Scribe**: API documentation generator
- **Laravel PWA**: Progressive Web App support

## Core Domains

### League Management

Handles the core functionality of running a billiard league:

- **Seasons**: Multi-season support with configurable settings
- **Teams**: Team registration and management
- **Players**: Player profiles and team assignments
- **Venues**: Location management for games

### Game Operations

Manages the actual gameplay and scoring:

- **Scheduling**: Game date and matchup scheduling
- **Scoring**: Real-time score entry and updates
- **Games**: Individual game tracking (15 games per match day)
- **Formats**: Game format definitions (singles, doubles)

### Statistics & Rankings

Provides analytical features:

- **Rankings**: Team and player rankings based on performance
- **Statistics**: Win/loss records, streaks, and performance metrics
- **Events**: Special events and milestones

### Community Features

Social and communication features:

- **Forum**: Discussion boards for league members
- **Chat**: Real-time messaging between users
- **Notifications**: System-wide announcements and alerts

### Administration

Administrative controls:

- **Admin Panel**: Administrative interface for league management
- **User Management**: User roles and permissions
- **Settings**: System configuration

## Key Architectural Decisions

### Why Livewire?

The application uses Livewire as the primary frontend framework because:

1. **Simplified Development**: Write reactive components in PHP without complex JavaScript
2. **Real-time Updates**: Built-in support for WebSocket connections
3. **Laravel Integration**: Seamless integration with Laravel's ecosystem
4. **SEO-Friendly**: Server-side rendering improves SEO

### Database Design Philosophy

- **Normalized Schema**: Proper normalization to avoid data redundancy
- **Soft Deletes**: Most models use soft deletes for data integrity
- **Timestamps**: All models track creation and modification times
- **Relationships**: Proper foreign key constraints and relationships

### Caching Strategy

- **Redis**: Used for session storage, cache, and queue backend
- **Query Caching**: Frequently accessed data is cached
- **Real-time Updates**: Cache invalidation on data changes

### Security Considerations

- **Authentication**: Multi-factor authentication support
- **Authorization**: Policy-based access control
- **Input Validation**: Request validation for all user inputs
- **CSRF Protection**: Built-in Laravel CSRF protection
- **SQL Injection Prevention**: Eloquent ORM prevents SQL injection

## Deployment Environment

The application is designed to run on:

- **Web Server**: Apache/Nginx
- **PHP**: Version 8.3 or higher
- **Database**: MySQL 8.0+ or MariaDB 10.5+
- **Cache/Queue**: Redis 6.0+
- **Storage**: AWS S3 or compatible service

## Non-Goals

This application is explicitly NOT designed for:

- Multi-league/multi-tenant deployments
- Commercial league management services
- Versioned releases (main branch only)
- Mobile native apps (PWA only)

## References

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
