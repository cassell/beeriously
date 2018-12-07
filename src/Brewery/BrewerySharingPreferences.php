<?php

declare(strict_types=1);

namespace Beeriously\Brewery;

class BrewerySharingPreferences
{
    /**
     * @var array
     */
    private $prefs;

    private function __construct(array $prefs)
    {
        $this->prefs = $prefs;
    }

    public static function defaultNotSharing(): self
    {
        $prefs = new self([]);
        $prefs->unshareTapList();

        return $prefs;
    }

    /**
     * @internal
     */
    public static function rehydrate(array $preferences): self
    {
        return new self($preferences);
    }

    public function isSharingTapList(): bool
    {
        return $this->isValueTrue('beer_list');
    }

    public function shareTapList(): void
    {
        $this->setValueTrue('beer_list');
    }

    public function unshareTapList(): void
    {
        $this->setValueFalse('beer_list');
    }

    public function toArray(): array
    {
        return [
            'beer_list' => $this->isSharingTapList(),
        ];
    }

    private function isValueTrue(string $key): bool
    {
        return array_key_exists($key, $this->prefs) && true === $this->prefs[$key];
    }

    private function setValueTrue(string $key): void
    {
        $this->prefs[$key] = true;
    }

    private function setValueFalse(string $key): void
    {
        $this->prefs[$key] = false;
    }
}
