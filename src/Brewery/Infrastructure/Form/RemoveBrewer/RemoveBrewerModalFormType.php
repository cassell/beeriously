<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\RemoveBrewer;

use Beeriously\Brewer\Brewer;
use Beeriously\Infrastructure\Form\ConfirmModalFormAbstractType;

class RemoveBrewerModalFormType extends ConfirmModalFormAbstractType
{
    public function getMessage(): string
    {
        return 'beeriously.brewery.remove_a_brewer.message';
    }

    public function getTitle(): string
    {
        return 'beeriously.brewery.remove_a_brewer.title';
    }

    public function getSubmitButtonText(): string
    {
        return 'beeriously.brewery.remove_a_brewer.submit_button';
    }

    protected function getMessageData($object): array
    {
        if ($object instanceof Brewer) {
            return [
                '%full_name%' => (string) $object->getFullName(),
            ];
        }

        return [];
    }
}
