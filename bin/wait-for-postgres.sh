#!/bin/sh
# https://stackoverflow.com/q/46516584/633864
until docker container exec -it phpquiz-postgres pg_isready; do
  >&2 echo "Postgres is unavailable - waiting for it... 😴"
  sleep 1
done
