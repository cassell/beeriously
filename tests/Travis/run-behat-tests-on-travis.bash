#!/usr/bin/env bash

vendor/bin/behat -c ./behat.travis-saucelabs.yml --colors -p win-chrome

if [ $? -eq 0 ]
then
	bin/console beeriously:sauce-labs:report-test passed
else
	bin/console beeriously:sauce-labs:report-test failed
	exit 1;
fi
