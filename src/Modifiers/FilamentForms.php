<?php

namespace Athphane\FilamentSupport\Modifiers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class FilamentForms
{
    public static function call(): void
    {
        // Make sure all form fields will have their labels in title case by default.
        Field::configureUsing(function (Field $component) {
            $name = $component->getName();

            // If the name ends with _id, remove the _id and replace all _ with a space
            if (str($name)->endsWith('_id')) {
                $name = str($name)->replace('_id', '')->replace('_', ' ');

                return $component->label(str($name)->title());
            }

            $label = $component->getLabel();

            if ($label !== null) {
                return $component->label(str($label)->title());
            }
        });

        TextInput::configureUsing(function (TextInput $textInput): void {
            $textInput
                ->dehydrateStateUsing(function (?string $state): ?string {
                    return is_string($state) ? Str::trim($state) : $state;
                });
        });

        /**
         * Quickly add helper text to a field as a hint icon.
         * The icon is always going to be the same, but the text can be changed.
         * Filament has a helperText() method, but this hint and tooltip is better.
         */
        Field::macro('helper', function (string $helperText) {
            return $this->hintIcon(Heroicon::OutlinedQuestionMarkCircle, $helperText);
        });

        // Force all select fields to be non-native fields for better UX
        Select::configureUsing(function (Select $component) {
            return $component->native(false);
        });

        Select::macro('enumSelect', function ($enum, $default = null) {
            // Expects enum with static formOptions() method returning options array
            return $this->options($enum::formOptions())
                ->default($default)
                ->allowHtml();
        });

        // All date pickers should be non-native, starting on Sunday and closing on the selected date
        DateTimePicker::configureUsing(function (DateTimePicker $component) {
            return $component->native(false)
                ->closeOnDateSelection()
                ->firstDayOfWeek(7);
        });

        // All date pickers should be non-native
        DatePicker::configureUsing(function (DatePicker $component) {
            return $component->native(false);
        });

        // All text areas should autosize
        Textarea::configureUsing(function (Textarea $component) {
            return $component->autosize();
        });

        TextInput::macro('autofocusOnCreate', function () {
            return $this->autofocus(static function (string $operation) {
                return $operation === 'create';
            });
        });

        Textarea::macro('autofocusOnCreate', function () {
            return $this->autofocus(static function (string $operation) {
                return $operation === 'create';
            });
        });

        TextInput::macro('hasSlugField', function (string $slug_field_name = 'slug') {
            return $this->lazy()
                ->afterStateUpdated(function ($state, callable $set, string $operation) use ($slug_field_name) {
                    if ($operation === 'create') {
                        $set($slug_field_name, Str::slug($state));
                    }
                });
        });
    }
}
