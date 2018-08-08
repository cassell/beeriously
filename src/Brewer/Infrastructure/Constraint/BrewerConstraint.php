<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @codeCoverageIgnore
 * @Annotation
 */
class BrewerConstraint extends Constraint
{
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
