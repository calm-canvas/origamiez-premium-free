# Docker Architecture Guide

This project uses a modular and highly reusable Docker Compose architecture. It is designed to be developer-friendly while providing a clear path for production deployment.

## Core Principles

1.  **Base + Override Model**: We separate the core service definitions from environment-specific configurations.
2.  **Modularization**: Service components (WordPress, CLI, Scheduler) are isolated into their own YAML files for better manageability.
3.  **YAML Anchors & Aliases**: Used extensively to eliminate redundancy and maintain a "Single Source of Truth."
4.  **Environment Agnostic**: The base configuration is clean and can be used as a blueprint for any environment (Dev, Staging, Prod).

## File Structure

- `docker-compose.yml`: The main entry point. It handles orchestration by including modular service definitions.
- `docker-compose.override.yml`: Contains all development-specific settings (ports, Xdebug, local volume mounts). This file is automatically merged by Docker Compose during local development.
- `docker/inc/`:
    - `common-defs.yml`: Defines reusable configuration blocks (logging, networks, database environment, etc.) using YAML anchors.
    - `wordpress.yml`: The blueprint for the WordPress Apache service.
    - `cli-scheduler.yml`: The blueprint for WP-CLI and the Ofelia scheduler.
- `.env`: Used to manage dynamic configuration like theme/plugin slugs and database credentials.

## Flexibility via Slugs

We use environment variables in the `.env` file to dynamically map the theme and plugin you are currently working on:

```bash
WP_THEME_SLUG=origamiez
WP_PLUGIN_SLUG=craftsman-suite
```

This allows the same Docker setup to be used for different WordPress projects simply by updating these slugs.
