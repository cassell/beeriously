<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure;

use Beeriously\Brewer\Application\Brewer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineBrewerRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getClassMetadata(Brewer::class));
    }
}
