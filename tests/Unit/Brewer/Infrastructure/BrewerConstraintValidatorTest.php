<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewer\Infrastructure;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\Constraint\BrewerConstraint;
use Beeriously\Brewer\Infrastructure\Constraint\BrewerConstraintValidator;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

class BrewerConstraintValidatorTest extends TestCase
{
    public function testInvalidUsername()
    {
        $context = $this->getMockExecutionContext();
        $context->expects($this->once())
            ->method('buildViolation')
            ->with('beeriously.brewer.registration.invalid_username')
            ->willReturn($this->getMockConstraintViolationBuilder())
        ;

        $constraint = new BrewerConstraintValidator($this->getMockTranslator());
        $constraint->initialize($context);

        $brewer = new Brewer();
        $brewer->setUsername('alc277');
        $brewer->setFirstName('Andrew');
        $brewer->setLastName('Cassell');
        $brewer->setPlainPassword('ad46da6a-5351-4ced-a646-8776b4824780');
        $brewer->setEmail('support@beeriously.com');
        $constraint->validate($brewer, new BrewerConstraint());
    }

    public function testInvalidPassword()
    {
        $context = $this->getMockExecutionContext();
        $context->expects($this->exactly(2)) // once for too short, once for match
            ->method('buildViolation')
            ->willReturn($this->getMockConstraintViolationBuilder());

        $constraint = new BrewerConstraintValidator($this->getMockTranslator());
        $constraint->initialize($context);

        $brewer = new Brewer();
        $brewer->setUsername('aaa');
        $brewer->setFirstName('Andrew');
        $brewer->setLastName('Cassell');
        $brewer->setPlainPassword('aaa');
        $brewer->setEmail('support@beeriously.com');
        $constraint->validate($brewer, new BrewerConstraint());
    }

    private function getMockExecutionContext()
    {
        $context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['buildViolation'])
            ->getMock()
        ;

        return $context;
    }

    private function getMockConstraintViolationBuilder()
    {
        $constraintViolationBuilder = $this->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $constraintViolationBuilder
            ->method('atPath')
            ->willReturn($constraintViolationBuilder);

        $constraintViolationBuilder
            ->method('addViolation')
            ->willReturn($constraintViolationBuilder);

        return $constraintViolationBuilder;
    }

    private function getMockTranslator()
    {
        $mock = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $mock->method('trans')->willReturnCallback(function ($value) {
            return $value;
        });

        return $mock;
    }
}
