<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Settings;

class BrewerySharingSettings
{
    /**
     * @var array
     */
    private $settings;

    private function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public static function defaultNotSharing(): self
    {
        $settings = new self([]);
        $settings->unshareTapList();

        return $settings;
    }

    /**
     * @internal
     */
    public static function rehydrate(array $settings): self
    {
        return new self($settings);
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
        return array_key_exists($key, $this->settings) && true === $this->settings[$key];
    }

    private function setValueTrue(string $key): void
    {
        $this->settings[$key] = true;
    }

    private function setValueFalse(string $key): void
    {
        $this->settings[$key] = false;
    }
}
