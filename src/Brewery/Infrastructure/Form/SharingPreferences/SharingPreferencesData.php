<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\SharingPreferences;

use Beeriously\Brewery\Brewery;

class SharingPreferencesData
{
    public $tapBeerList = false;

    public static function fromBrewery(Brewery $brewery): self
    {
        $data = new self();
        $data->tapBeerList = $brewery->isSharingTapList();

        return $data;
    }

    public function shouldShareTapList()
    {
        return true === $this->tapBeerList;
    }
}
