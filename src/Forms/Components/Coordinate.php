<?php

namespace Athphane\FilamentSupport\Forms\Components;

use Filament\Forms\Components\Field;

class Coordinate extends Field
{
    protected string $view = 'filament-support::forms.components.coordinate';

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

        $this->afterStateHydrated(function (Coordinate $component, $record, $state) {
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

        $this->beforeStateDehydrated(function (Coordinate $component, $state) {
        });

        $this->dehydrated(true);
    }
}
