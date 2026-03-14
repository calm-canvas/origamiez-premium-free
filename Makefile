.PHONY: up down remove restart setup network-check

# Environment setup
setup:
	@if [ ! -f .env ]; then \
		cp .env.example .env; \
		echo "✅ .env file created from .env.example"; \
	fi
	@$(MAKE) network-check

# Check if docker network 'dev_tools' exists, create if not
network-check:
	@if ! docker network inspect dev_tools >/dev/null 2>&1; then \
		if docker network create dev_tools >/dev/null 2>&1; then \
			echo "✅ Network 'dev_tools' created"; \
		else \
			echo "❌ Error: Failed to create network 'dev_tools'. Is Docker running?"; \
			exit 1; \
		fi; \
	fi

# Docker Compose commands
up: setup
	docker compose up -d

down:
	docker compose down

remove:
	docker compose down -v

restart:
	docker compose restart
