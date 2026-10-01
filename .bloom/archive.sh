#!/usr/bin/env bash

# Stop on unset variables. Errors are tolerated below so teardown can run
# again safely, even if setup only partly finished.
set -u

# Rebuild the same site name that setup.sh used for this workspace.
SITE="my-app-$(printf '%s' "$BLOOM_WORKSPACE_ID" | tr -cd '[:alnum:]' | cut -c1-10)"

# Remove the HTTPS certificate and the Herd link for this workspace's site.
herd unsecure "$SITE" || true
herd unlink "$SITE" || true

# Delete this workspace's SQLite database, including any WAL/journal files.
DATABASE="$PWD/database/database.sqlite"
rm -f "$DATABASE" "$DATABASE-wal" "$DATABASE-shm" "$DATABASE-journal"
