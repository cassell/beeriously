<?php
declare(strict_types=1);

namespace Beeriously\Infrastructure\Travis;

use Sauce\Sausage\SauceAPI;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SauceLabsSeleniumTestReportCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'beeriously:sauce-labs:report-test';

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Report SauceLabs Selenium Test Passed or Failed')
            ->addArgument(
                'result',
                InputArgument::REQUIRED,
                'Result of Test'
            );

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var SauceAPI $sauceAPI */
        $sauceAPI = new SauceAPI($this->getSauceUsername(), $this->getSauceKey());

        $most_recent_test = $sauceAPI->getJobs(0)['jobs'][0];

        $sauceAPI->updateJob($most_recent_test['id'], [
            'passed' => $input->getArgument('result') === "passed",
            'name' => \getenv('TRAVIS_JOB_ID')
        ]);

    }

    /**
     * @return array|false|string
     */
    protected function getSauceUsername()
    {
        return \getenv('SAUCE_USERNAME');
    }

    /**
     * @return array|false|string
     */
    protected function getSauceKey()
    {
        return \getenv('SAUCE_ACCESS_KEY');
    }
}