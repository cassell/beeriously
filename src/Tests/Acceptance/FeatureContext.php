<?php

declare(strict_types=1);

namespace Beeriously\Tests\Acceptance;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext implements Context
{
    /**
     * @Then /^I wait (\d+) seconds$/
     */
    public function iWaitSeconds(int $seconds)
    {
        sleep($seconds);
    }
}
