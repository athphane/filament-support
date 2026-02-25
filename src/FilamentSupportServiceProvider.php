<?php

namespace Athphane\FilamentSupport;

use Athphane\FilamentSupport\Commands\FilamentSupportCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSupportServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-support')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament_support_table')
            ->hasCommand(FilamentSupportCommand::class);
    }
}
