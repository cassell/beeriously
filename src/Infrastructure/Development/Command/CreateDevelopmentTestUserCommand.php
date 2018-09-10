<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Development\Command;

use Beeriously\Tests\Helpers\TestBreweryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDevelopmentTestUserCommand extends ContainerAwareCommand
{
    const COMMAND_NAME = 'beeriously:development:setupDevUser';

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Create a Development User');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getContainer()->get(EntityManagerInterface::class);

        $brewery = TestBreweryBuilder::createBrewery('Duff', 'Barry', 'Duffman');
        $brewer = TestBreweryBuilder::getOwner($brewery);
        $brewer->setUsername('duffman');
        $brewer->setPlainPassword('ohyeah');
        $brewer->setEmail('duff@beeriously.com');

        $output->write("\n");
        $output->write('Username: duffman');
        $output->write("\n");
        $output->write('Password: ohyeah');
        $output->write("\n");
        $output->write("\n");

        $em->persist($brewery);
        $em->flush();
    }
}
