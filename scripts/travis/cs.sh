#!/usr/bin/env bash
cd $TESTDIR
composer install
./vendor/bin/phpcs
