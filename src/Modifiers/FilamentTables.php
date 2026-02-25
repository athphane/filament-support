<?php

namespace Athphane\FilamentSupport\Modifiers;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Arr;

class FilamentTables
{
    public static function call(): void
    {
        // Make sure all table columns are in title case
        TextColumn::configureUsing(function (TextColumn $column) {
            $column->label(str($column->getLabel())->title());
        });

        // Make all table filter select fields non-native
        SelectFilter::configureUsing(function (SelectFilter $filter) {
            $filter->native(false);
        });

        TextColumn::macro('hiddenOnRelationManager', function (string|array $relationManager) {
            return $this->hidden(function ($livewire) use ($relationManager) {
                foreach (Arr::wrap($relationManager) as $relationManager) {
                    if ($livewire instanceof $relationManager) {
                        return true;
                    }
                }

                return false;
            });
        });

        // TextColumn::macro('defaultMoney', function () {
        //     return $this->money(settings('app', 'currency'));
        // });

        Tab::macro('iconStart', function () {
            return $this->iconPosition(IconPosition::Before);
        });

        Tab::macro('iconEnd', function () {
            return $this->iconPosition(IconPosition::After);
        });

        Tab::configureUsing(function (Tab $tab) {
            return $tab->iconPosition(IconPosition::After);
        });

        EditAction::configureUsing(function (EditAction $action) {
            return $action->color('amber');
        });

        DeleteAction::configureUsing(function (DeleteAction $action) {
            return $action->color('danger');
        });

        Table::configureUsing(function (Table $table) {
            return $table->deferFilters();
        });
    }
}
