<?php

namespace Athphane\FilamentSupport\Forms\Components;

use Athphane\FilamentSupport\Enums\PublishStatuses;
use Filament\Forms\Components\Select;

class PublishStatusSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('Status'))
            ->options(PublishStatuses::class)
            ->default(function ($model) {
                return auth()->user()->can('publish', $model)
                    ? PublishStatuses::PUBLISHED
                    : PublishStatuses::DRAFT;
            })
            ->required();
    }
}
