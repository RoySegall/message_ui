#!/usr/bin/env bash
# Download Drupal 8 core.
travis_retry git clone --branch $DRUPAL_CORE --depth 1 https://git.drupal.org/project/drupal.git
cd drupal

# install Drupal
composer require drush/drush
# Get modules
vendor/drush/drush/drush dl message
vendor/drush/drush/drush dl message_notify

# Reference Message UI in the Drupal site.
ln -s $TESTDIR modules/message_ui

# Start a web server on port 8888 in the background.
nohup php -S localhost:8888 > /dev/null 2>&1 &

# Wait until the web server is responding.
until curl -s localhost:8888; do true; done > /dev/null

# Export web server URL for browser tests.
export SIMPLETEST_BASE_URL=http://localhost:8888

# Run the PHPUnit tests which also include the kernel tests.
./vendor/phpunit/phpunit/phpunit -c ./core/phpunit.xml.dist ./modules/message_ui
