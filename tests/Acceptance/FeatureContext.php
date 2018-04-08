<?php

declare(strict_types=1);

namespace Beeriously\Tests\Acceptance;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\ORM\EntityManager;

class FeatureContext implements Context
{

    /**
     * @Then /^I wait (\d+) seconds$/
     */
    public function iWaitSeconds(int $seconds)
    {
        sleep($seconds);
    }
}
