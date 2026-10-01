#!/usr/bin/env bash

# Stop on errors or unset variables.
set -eu

# Bloom provides the original checkout path and this workspace's ID.
# Start with the original project's environment settings.
cp "$BLOOM_ROOT_PATH/.env" .env

# Set KEY=VALUE in .env, replacing the line if it exists or appending it if not.
set_env() {
    if grep -q "^$1=" .env; then
        sed -i '' "s|^$1=.*|$1=$2|" .env
    else
        printf '%s=%s\n' "$1" "$2" >> .env
    fi
}

# Give this workspace its own HTTPS .test domain with Laravel Herd.
SITE="my-app-$(printf '%s' "$BLOOM_WORKSPACE_ID" | tr -cd '[:alnum:]' | cut -c1-10)"
herd link "$SITE"
herd secure "$SITE"
set_env APP_URL "https://$SITE.test"

# Use a SQLite database inside this workspace so the main checkout is untouched.
# Only create the file if it doesn't exist, so setup can run again.
DATABASE="$PWD/database/database.sqlite"
mkdir -p "$(dirname "$DATABASE")"
[ -f "$DATABASE" ] || touch "$DATABASE"
set_env DB_CONNECTION sqlite
set_env DB_DATABASE "$DATABASE"

# Install PHP and JavaScript dependencies, then build the frontend assets.
composer install
pnpm install
pnpm run build

# Create the tables and seed the workspace database with initial data.
php artisan migrate --seed --force
