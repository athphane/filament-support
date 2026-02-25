<?php

namespace Athphane\FilamentSupport\Infolists\Components;

use Filament\Infolists\Components\Entry;

class CoordinateMap extends Entry
{
    protected string $view = 'filament-support::infolists.components.coordinate-map';

    protected float $defaultLatitude = 4.1749020562625;

    protected float $defaultLongitude = 73.507861196995;

    protected int $mapHeight = 400;

    public function defaultCoordinates(float $lat, float $lng): static
    {
        $this->defaultLatitude = $lat;
        $this->defaultLongitude = $lng;

        return $this;
    }

    public function mapHeight(int $height): static
    {
        $this->mapHeight = $height;

        return $this;
    }

    public function getDefaultLatitude(): float
    {
        return $this->defaultLatitude;
    }

    public function getDefaultLongitude(): float
    {
        return $this->defaultLongitude;
    }

    public function getMapHeight(): int
    {
        return $this->mapHeight;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (CoordinateMap $component, $record, $state) {
            if ($record?->coordinates) {
                $state = $record->coordinates;
            }

            if (is_object($state) && isset($state->latitude, $state->longitude)) {
                $newState = [
                    'lat' => $state->latitude,
                    'lng' => $state->longitude,
                ];

                $component->state($newState);
            } elseif (! is_array($state) || ! isset($state->latitude) || ! isset($state->longitude)) {
                $newState = [
                    'lat' => $this->defaultLatitude,
                    'lng' => $this->defaultLongitude,
                ];

                $component->state($newState);
            }
        });
    }
}
