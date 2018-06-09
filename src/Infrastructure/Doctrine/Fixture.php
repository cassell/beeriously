<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Doctrine;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

/**
 * @codeCoverageIgnore
 */
abstract class Fixture extends \Doctrine\Bundle\FixturesBundle\Fixture implements ORMFixtureInterface
{
}
