<?php

namespace Athphane\FilamentSupport\Modifiers;

use Filament\Infolists\Components\TextEntry;

class FilamentInfolists
{
    public static function call(): void
    {
        TextEntry::configureUsing(function (TextEntry $component) {
            return $component
                ->label(str($component->getLabel())->title());
        });

        TextEntry::macro('enum', function () {
            return $this
                ->formatStateUsing(function ($state) {
                    return $state?->label() ?? $state;
                })
                ->badge()
                ->color(function ($state) {
                    return $state?->color() ?? null;
                });
        });
    }
}
