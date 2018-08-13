<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Constraint;

use Beeriously\Brewer\Application\Brewer;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BrewerConstraintValidator extends ConstraintValidator
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function validate($protocol, Constraint $constraint)
    {
        if (!$protocol instanceof Brewer) {
            throw new \RuntimeException();
        }

        if ($this->shouldUsernameNotBeAllowed($protocol)) {
            $this->addViolation('beeriously.brewer.registration.invalid_username', 'username');
        }

        if (!empty($protocol->getPlainPassword())) {
            if ($this->isPasswordTooShort($protocol)) {
                $this->addViolation('beeriously.brewer.registration.password_too_short', 'plainPassword');
            }
            if ($this->doesPasswordMatchUsernameOrEmail($protocol)) {
                $this->addViolation('beeriously.brewer.registration.password_can_not_match_email_or_username', 'plainPassword');
            }
        }
    }

    /**
     * @return array
     */
    private static function invalidUsernames(): array
    {
        $unavailableUsernames = [
            'admin',
            'administrator',
            'alc277',
            'beer',
            '🍺',
            'beeriously',
            'brew',
            'brewing',
            'root',
            'obama',
            'support',
            'trump',
        ];

        return $unavailableUsernames;
    }

    private function shouldUsernameNotBeAllowed(Brewer $brewer): bool
    {
        return in_array($brewer->getUsername(), self::invalidUsernames(), true);
    }

    private function isPasswordTooShort(Brewer $brewer): bool
    {
        return mb_strlen($brewer->getPlainPassword()) < 7;
    }

    private function doesPasswordMatchUsernameOrEmail(Brewer $brewer): bool
    {
        return mb_strtolower($brewer->getPlainPassword()) === mb_strtolower($brewer->getUsername())
            || mb_strtolower($brewer->getPlainPassword()) === mb_strtolower($brewer->getEmail());
    }

    private function addViolation(string $message, string $field): void
    {
        $this->context->buildViolation($this->translator->trans($message))
            ->atPath($field)
            ->addViolation();
    }
}
