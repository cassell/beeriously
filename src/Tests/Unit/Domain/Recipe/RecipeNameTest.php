<?php

namespace Beeriously\Tests\Unit\Domain\Recipe;

use Beeriously\Domain\Recipe\InvalidRecipeNameException;
use Beeriously\Domain\Recipe\RecipeName;
use PHPUnit\Framework\TestCase;

class RecipeNameTest extends TestCase
{
    public function testEmptyFails(): void
    {
        $this->expectException(InvalidRecipeNameException::class);
        $this->expectExceptionMessage("Recipe name can not be empty.");
        new RecipeName("");
    }

    public function testGetter(): void
    {
        $s = new RecipeName("iPHPA");
        $this->assertEquals("iPHPA", $s->getValue());
    }

    public function testToString(): void
    {
        $s = new RecipeName("Recursiweizen");
        $this->assertEquals("Recursiweizen", (string)$s);
    }

}

