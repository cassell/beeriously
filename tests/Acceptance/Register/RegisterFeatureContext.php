<?php

declare(strict_types=1);

namespace Beeriously\Tests\Acceptance\Register;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\DoctrineBrewerRepository;
use Beeriously\Tests\Acceptance\FeatureContext;
use Behat\Behat\Context\Context;

class RegisterFeatureContext extends FeatureContext implements Context
{
    /**
     * @When /^I follow the activation link that was sent in an email for user "([^"]*)"$/
     */
    public function iFollowTheActivationLinkThatWasSentInAnEmailForUser(string $username)
    {
        $brewer = $this->getBrewer($username);

        return $this->visit('/us/register/confirm/'.$brewer->getConfirmationToken());
    }

    private function getBrewer(string $username): Brewer
    {
        /** @var Brewer $brewer */
        $brewer = $this->getBrewerRepository()->findOneBy(['username' => $username]);

        return $brewer;
    }

    private function getBrewerRepository(): DoctrineBrewerRepository
    {
        /** @var DoctrineBrewerRepository $repo */
        $repo = $this->getEntityManager()->getRepository(Brewer::class);

        return $repo;
    }
}
