#!/bin/bash
set -e

# Trap signals for graceful shutdown
trap 'kill -TERM $PID' TERM INT

# Start supervisor in the background
"$@" &
PID=$!

# Wait for supervisor process
wait $PID
TRAP_EXIT=$?

# Cleanup on exit
exit $TRAP_EXIT
