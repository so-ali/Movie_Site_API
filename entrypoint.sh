#!/bin/sh
set -e
if [ "$1" = 'php-fpm' ]; then
    export APP_ENV
    echo "Waiting for db to be ready..."
    ATTEMPTS_LEFT_TO_REACH_DATABASE=60
    until [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ] || DATABASE_ERROR=$(php artisan app:check-db -t 2>&1); do
        echo $(php artisan app:check-db -t 2>&1);
        # shellcheck disable=SC2181
        if [ $? -eq 0 ]; then
            break
        fi
        sleep 1
        ATTEMPTS_LEFT_TO_REACH_DATABASE=$((ATTEMPTS_LEFT_TO_REACH_DATABASE - 1))
        echo "Still waiting for db to be ready... Or maybe the db is not reachable. $ATTEMPTS_LEFT_TO_REACH_DATABASE attempts left"
    done

    if [ $ATTEMPTS_LEFT_TO_REACH_DATABASE -eq 0 ]; then
        echo "The database is not up or not reachable:"
        echo "$DATABASE_ERROR"
        exit 1
    else
        echo "The db is now ready and reachable"
    fi

    if [ "${APP_ENV}" = "local" ] ; then
        php artisan migrate:fresh --seed;
    else
        php artisan optimize:clear
        php artisan optimize
    fi
fi

php artisan flush:redis

exec docker-php-entrypoint "$@"
