<?php

namespace Athphane\FilamentSupport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Athphane\FilamentSupport\FilamentSupport
 */
class FilamentSupport extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Athphane\FilamentSupport\FilamentSupport::class;
    }
}
