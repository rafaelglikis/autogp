#!/bin/bash
cd tests
../vendor/phpunit/phpunit/phpunit . --coverage-text --color
echo cleanning the mess . . .
rm fixtures/wordpress/test/*
cd ..