<?php

namespace Athphane\FilamentSupport\Modifiers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

class FilamentActions
{
    public static function call(): void
    {
        Action::configureUsing(function (Action $action) {
            $action->iconPosition(IconPosition::After);
        });

        CreateAction::configureUsing(function (CreateAction $action) {
            $action->icon(Heroicon::Plus);
        });

        DeleteAction::configureUsing(function (DeleteAction $action) {
            $action->icon(Heroicon::OutlinedTrash);
        });
    }
}
