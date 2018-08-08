<?php

declare(strict_types=1);

namespace Beeriously\Tests\Acceptance\Register;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\DoctrineBrewerRepository;
use Beeriously\Tests\Acceptance\FeatureContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class RegisterFeatureContext extends FeatureContext implements Context
{
    /**
     * @When /^I follow the activation link that was sent in an email for user "([^"]*)"$/
     */
    public function iFollowTheActivationLinkThatWasSentInAnEmailForUser(string $username)
    {
        $brewer = $this->getBrewer($username);
        return $this->visit("/us/register/confirm/".$brewer->getConfirmationToken());
    }

    private function getBrewer(string $username): Brewer
    {
        return $this->getBrewerRepository()->findOneBy(['username' => $username]);
    }

    private function getBrewerRepository(): DoctrineBrewerRepository
    {
        return $this->getEntityManager()->getRepository(Brewer::class);
    }


}
