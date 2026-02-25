<?php

namespace Athphane\FilamentSupport;

use Athphane\FilamentSupport\Modifiers\FilamentActions;
use Athphane\FilamentSupport\Modifiers\FilamentForms;
use Athphane\FilamentSupport\Modifiers\FilamentInfolists;
use Athphane\FilamentSupport\Modifiers\FilamentSummarizers;
use Athphane\FilamentSupport\Modifiers\FilamentTables;
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
            // ->hasMigration('create_filament_support_table')
            // ->hasCommand(FilamentSupportCommand::class)
        ;
    }

    public function bootingPackage(): void
    {
        $config = $this->app['config'];

        if ($config->get('filament-support.modifiers.forms', true)) {
            FilamentForms::call();
        }

        if ($config->get('filament-support.modifiers.actions', true)) {
            FilamentActions::call();
        }

        if ($config->get('filament-support.modifiers.tables', true)) {
            FilamentTables::call();
        }

        if ($config->get('filament-support.modifiers.infolists', true)) {
            FilamentInfolists::call();
        }

        if ($config->get('filament-support.modifiers.summarizers', true)) {
            FilamentSummarizers::call();
        }
    }
}
