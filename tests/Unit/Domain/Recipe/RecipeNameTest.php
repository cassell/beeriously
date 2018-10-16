<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Recipe;

use Beeriously\Domain\Recipe\RecipeName;
use PHPUnit\Framework\TestCase;

class RecipeNameTest extends TestCase
{
    public function testEmptyFails(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Recipe name can not be empty.');
        new RecipeName('');
    }

    public function testGetter(): void
    {
        $s = new RecipeName('iPHPA');
        $this->assertEquals('iPHPA', $s->getValue());
    }

    public function testToString(): void
    {
        $s = new RecipeName('Recursiweizen');
        $this->assertEquals('Recursiweizen', (string) $s);
    }
}
