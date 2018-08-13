<?php

declare(strict_types=1);

namespace Beeriously\Tests\Acceptance;

use Beeriously\Tests\Helpers\TestBreweryBuilder;
use Behat\Behat\Context\Context;
use Behat\Behat\Definition\Call\Given;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @codeCoverageIgnore
 */
class FeatureContext extends MinkContext implements Context, KernelAwareContext
{
    protected $kernel;

    public function setKernel(KernelInterface $kernelInterface)
    {
        $this->kernel = $kernelInterface;
    }

    /**
     * @Then /^I wait (\d+) seconds$/
     */
    public function iWaitSeconds(int $seconds)
    {
        sleep($seconds);
    }

    /**
     * @Given /^I click on "([^"]*)"$/
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function iClickOn(string $text)
    {
        $this->getSession()->getPage()->clickLink($text);
    }

    public function getEntityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getKernel()->getContainer()->get('doctrine.orm.entity_manager');

        return $em;
    }

    /**
     * @Given /^I am logged in as "([^"]*)" owner of "([^"]*)"$/
     *
     * @throws UnsupportedDriverActionException
     */
    public function iAmLoggedInAsOwnerOf(string $brewerName, string $breweryName)
    {
        $name = preg_split('/ /', $brewerName);
        $brewery = TestBreweryBuilder::createBrewery($breweryName, $name[0], $name[1]);
        $owner = TestBreweryBuilder::getOwner($brewery);

        $this->getEntityManager()->persist($brewery);
        $this->getEntityManager()->flush();

        $this->visit('/us/login');
        $this->fillField('_username', $owner->getUsername());
        $this->fillField('_password', TestBreweryBuilder::TEST_PASSWORD);
        $this->pressButton('Log in');
    }

    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }

    /**
     * @Given /^I open the application menu if it's not open$/
     */
    public function iOpenTheApplicationMenuIfItSNotOpen()
    {
        $this->getSession()->executeScript("
            $('#beeriously-nav-menu-button').click();
        ");
    }

    /**
     * @Given /^I navigate the application menu to "([^"]*)"$/
     */
    public function iNavigateTheApplicationMenuTo($arg1)
    {
        $this->iOpenTheApplicationMenuIfItSNotOpen();
        $this->clickLink($arg1);
    }
}
