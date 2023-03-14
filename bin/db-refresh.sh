#!/bin/bash

# To be run from project ROOT directory

# Delete the sqlite file
if [ -e ./var/data/rdbms/application.sqlite3 ]; then
  echo "RDBMS exists. drop and create"
  rm -f "./var/data/rdbms/application.sqlite3"
fi

# Migrate the cart and stock schema
php vendor/bin/phinx migrate -c resources/rdbms/phinx/phinx.php -e dev

# Seed the stock data
php vendor/bin/phinx seed:run -c resources/rdbms/phinx/phinx.php -e dev
