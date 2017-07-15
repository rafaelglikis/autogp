#!/bin/bash
cd tests
../vendor/phpunit/phpunit/phpunit .
#../vendor/phpunit/phpunit/phpunit . --coverage-text
cd ..