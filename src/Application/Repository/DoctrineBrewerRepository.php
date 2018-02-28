<?php

declare(strict_types=1);

namespace Beeriously\Application\Repository;

use Beeriously\Application\Brewers\Brewer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineBrewerRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        /* @var EntityManager $em */
        parent::__construct($em, $em->getClassMetadata(Brewer::class));
    }
}
