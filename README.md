# Filament Support

[![Latest Version on Packagist](https://img.shields.io/packagist/v/athphane/filament-support.svg?style=flat-square)](https://packagist.org/packages/athphane/filament-support)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/athphane/filament-support/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/athphane/filament-support/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/athphane/filament-support/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/athphane/filament-support/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/athphane/filament-support.svg?style=flat-square)](https://packagist.org/packages/athphane/filament-support)

Helper traits, base component configs, and shared utilities for Filament.

## Installation

You can install the package via composer:

```bash
composer require athphane/filament-support
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-support-config"
```

## Configuration

The published config file allows you to enable/disable specific modifiers:

```php
// config/filament-support.php

return [
    'modifiers' => [
        'forms' => env('FILAMENT_SUPPORT_MODIFIER_FORMS', true),
        'actions' => env('FILAMENT_SUPPORT_MODIFIER_ACTIONS', true),
        'tables' => env('FILAMENT_SUPPORT_MODIFIER_TABLES', true),
        'infolists' => env('FILAMENT_SUPPORT_MODIFIER_INFOLISTS', true),
        'summarizers' => env('FILAMENT_SUPPORT_MODIFIER_SUMMARIZERS', true),
    ],
];
```

All modifiers are enabled by default.

## Features

### Modifiers

The package provides automatic configuration for Filament components:

- **Forms**: Auto-title labels, trim text input values, native date pickers, helper icons
- **Actions**: Set icon positions and default icons
- **Tables**: Title case labels, non-native filters, hidden on relation manager macro
- **Infolists**: Title case labels, enum display macro
- **Summarizers**: Default money summarizer

### Components

#### Coordinate (Form Component)

A Google Maps coordinate picker for Filament forms.

```php
use Athphane\FilamentSupport\Forms\Components\Coordinate;

Coordinate::make('coordinates')
    ->defaultCoordinates(4.1749, 73.5079)
    ->mapHeight(500);
```

#### PublishStatusSelect (Form Component)

A dropdown for content publishing status.

```php
use Athphane\FilamentSupport\Forms\Components\PublishStatusSelect;

PublishStatusSelect::make('status');
```

#### SpatieMediaLibraryFileUpload (Form Component)

Enhanced file upload with automatic disk configuration.

```php
use Athphane\FilamentSupport\Forms\Components\SpatieMediaLibraryFileUpload;

SpatieMediaLibraryFileUpload::make('attachment');
```

#### CoordinateMap (Infolist Component)

Read-only coordinate map display.

```php
use Athphane\FilamentSupport\Infolists\Components\CoordinateMap;

CoordinateMap::make('coordinates');
```

### Enums

#### PublishStatuses

Enum for content publishing status with Filament integration.

```php
use Athphane\FilamentSupport\Enums\PublishStatuses;

// Options: DRAFT, PENDING, PUBLISHED, REJECTED
// Includes color, icon, and label methods for Filament
```

### Traits

#### FilamentAdminUrls

Generate admin URLs for model records.

```php
use Athphane\FilamentSupport\Traits\FilamentAdminUrls;

class Post extends Model
{
    use FilamentAdminUrls;

    // Disable admin URL generation if needed
    public function disableAdminUrlGeneration(): bool
    {
        return true;
    }
}

// Usage
$adminUrl = $post->getAdminUrl('edit');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Athfan Khaleel](https://github.com/athphane)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
