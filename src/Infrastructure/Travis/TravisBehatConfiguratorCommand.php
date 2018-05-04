<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Travis;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

class TravisBehatConfiguratorCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'beeriously:travis:configure-behat';

    private $twig;

    public function __construct(Environment $twig)
    {
        parent::__construct(null);
        $this->twig = $twig;
    }

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Configure Behat Tests On Travis');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write($this->twig->render('testing/behat.travis-saucelabs.yml.template', [
            'SAUCE_USERNAME' => \getenv('SAUCE_USERNAME'),
            'SAUCE_ACCESS_KEY' => \getenv('SAUCE_ACCESS_KEY'),
        ]));
    }
}
