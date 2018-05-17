#!/usr/bin/env bash

if [ vendor/bin/behat -c ./behat.travis-saucelabs.yml --colors -p win-chrome ];
then
	bin/console beeriously:sauce-labs:report-test passed
else
	bin/console beeriously:sauce-labs:report-test failed
	exit 1;
fi
