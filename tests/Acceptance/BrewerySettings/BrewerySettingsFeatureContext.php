<?php

declare(strict_types=1);

namespace Beeriously\Tests\Acceptance\BrewerySettings;

use Beeriously\Tests\Acceptance\FeatureContext;
use Behat\Behat\Context\Context;
use WebDriver\Exception\NoSuchElement;

class BrewerySettingsFeatureContext extends FeatureContext implements Context
{
    /**
     * @Given /^I fill out brewery name form with "([^"]*)"$/
     */
    public function iFillOutBreweryNameFormWith($arg1)
    {
        $this->fillField('brewery_change_name_form[name]', $arg1);
    }

    /**
     * @Given /^I click submit change brewery name$/
     *
     * @throws NoSuchElement
     */
    public function iClickSubmitChangeBreweryName()
    {
        $element = $this->getSession()->getPage()->find('xpath', '//*[@id="brewery_change_name_form"]/div/div/div[2]/button[1]/i');
        if (null === $element) {
            throw new NoSuchElement();
        }
        $element->click();
        $this->iWaitSeconds(5);
    }

    /**
     * @Then /^I click the first delete button in the list of brewers$/
     */
    public function iClickTheFirstDeleteButtonInTheListOfBrewers()
    {
        $this->getSession()->executeScript("
            $('#beeriously-brewery-settings-brewers-list button').first().click();
        ");
    }
}
