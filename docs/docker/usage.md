# Docker Usage Guide

This project provides a `Makefile` to simplify common Docker operations.

## Initial Setup

Before starting for the first time, run the setup command:

```bash
make setup
```

This will:
1. Create a `.env` file from `.env.example` if it doesn't already exist.
2. Check if the `dev_tools` Docker network exists and create it if necessary.

## General Commands

### Start Services

```bash
make up
```

Starts all containers in detached mode (`-d`). This ensures the network is ready before booting.

### Stop Services

```bash
make down
```

Stops and removes containers while preserving volumes.

### Full Cleanup

```bash
make remove
```

Stops and removes containers **including volumes**. Use this when you want to reset the database.

### Restart

```bash
make restart
```

Restarts all running containers.

## Configuration (Env Variables)

Edit the `.env` file to customize your environment:

- **WP_PORT**: The port where WordPress will be available on your host.
- **WP_THEME_SLUG**: The directory name of the theme you're working on.
- **WP_PLUGIN_SLUG**: The directory name of the primary plugin you're working on.
- **WORDPRESS_DEBUG**: Toggle WordPress debug mode.
