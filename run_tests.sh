#!/bin/bash
cd tests
../vendor/phpunit/phpunit/phpunit . --coverage-text --color
echo cleanning the mess . . .
rm fixtures/wordpress/test/*
rm -rf sessions
rm key_value_test.db
cd ..