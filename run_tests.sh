#!/bin/bash
cd tests

if  [[ $1 == "--coverage" ]];
then
    ../vendor/phpunit/phpunit/phpunit . --coverage-text --color
else
    ../vendor/phpunit/phpunit/phpunit . --color
fi

echo cleanning the mess . . .
rm fixtures/wordpress/test/*
rm -rf sessions
rm key_value_test.db
cd ..