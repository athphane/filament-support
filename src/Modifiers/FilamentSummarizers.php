<?php

namespace Athphane\FilamentSupport\Modifiers;

use Filament\Tables\Columns\Summarizers\Summarizer;

class FilamentSummarizers
{
    public static function call(): void
    {
        Summarizer::macro('defaultMoney', function (string $currency = 'USD') {
            return $this->money($currency);
        });
    }
}
