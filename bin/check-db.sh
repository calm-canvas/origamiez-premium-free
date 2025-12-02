#!/bin/bash
set -e

DB_HOST="${WORDPRESS_DB_HOST:-mysql8}"
DB_USER="${WORDPRESS_DB_USER:-root}"
DB_PASSWORD="${WORDPRESS_DB_PASSWORD:-password102}"
DB_NAME="${WORDPRESS_DB_NAME:-origamiez}"
DB_PORT="${WORDPRESS_DB_PORT:-3306}"

echo "🔍 Checking database connection..."
echo "Host: $DB_HOST"
echo "Port: $DB_PORT"
echo "User: $DB_USER"
echo "Database: $DB_NAME"
echo ""

if docker compose exec -T wordpress mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" -e "SELECT 1" > /dev/null 2>&1; then
  echo "✅ Database server is accessible"
else
  echo "❌ Failed to connect to database server"
  exit 1
fi

if docker compose exec -T wordpress mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" -e "USE $DB_NAME; SHOW TABLES LIMIT 1;" > /dev/null 2>&1; then
  echo "✅ Database '$DB_NAME' exists and is accessible"
  TABLE_COUNT=$(docker compose exec -T wordpress mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$DB_NAME';" | tail -1)
  echo "   Tables: $TABLE_COUNT"
else
  echo "⚠️  Database '$DB_NAME' does not exist or is not accessible"
  exit 1
fi

echo ""
echo "✅ Database connection successful!"
