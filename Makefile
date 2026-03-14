.PHONY: up down remove restart setup network-check

# Environment setup
setup:
	@echo "🔧 Starting environment setup..."
	@# Create .env from example if it doesn't exist
	@if [ ! -f .env ]; then \
		cp .env.example .env && echo "✅ .env file created from .env.example"; \
	else \
		echo "ℹ️  Using existing .env file."; \
	fi
	@# Create override.ini from example if it doesn't exist
	@if [ ! -f docker/config/override.ini ]; then \
		if [ -f docker/config/override.ini.example ]; then \
			cp docker/config/override.ini.example docker/config/override.ini && echo "✅ docker/config/override.ini created from example"; \
		else \
			echo "⚠️  Warning: docker/config/override.ini.example not found."; \
		fi; \
	else \
		echo "ℹ️  Using existing docker/config/override.ini."; \
	fi
	@$(MAKE) network-check
	@echo "🚀 Setup finished successfully!"

# Check if docker network 'dev_tools' exists, create if not
network-check:
	@echo "🌐 Checking Docker network 'dev_tools'..."
	@if ! docker network inspect dev_tools >/dev/null 2>&1; then \
		if docker network create dev_tools >/dev/null 2>&1; then \
			echo "✅ Network 'dev_tools' created."; \
		else \
			echo "❌ Error: Failed to create network 'dev_tools'. Is Docker running?"; \
			exit 1; \
		fi; \
	else \
		echo "✅ Network 'dev_tools' is available."; \
	fi

# Docker Compose commands
up: setup
	@echo "🐳 Powering up Docker containers..."
	docker compose up -d
	@echo "✨ Environment is ready."

down:
	@echo "🛑 Shutting down containers..."
	docker compose down
	@echo "✅ Containers stopped."

remove:
	@echo "🗑️  Cleaning up containers and volumes..."
	docker compose down -v
	@echo "✅ Environment removed."

restart:
	@echo "🔄 Restarting services..."
	docker compose restart
	@echo "✅ Restarted successfully."
