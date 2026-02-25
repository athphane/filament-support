# Changelog

All notable changes to `filament-support` will be documented in this file.

## v1.0.0 - 2026-02-25

### Features

- Filament component modifiers for Forms, Actions, Tables, Infolists, and Summarizers
- Configurable modifiers via config file (enable/disable individually)
- Auto-registration in service provider

### Forms Components

- `Coordinate` - Google Maps coordinate picker with drag-and-drop
- `PublishStatusSelect` - Status selection dropdown for draft/pending/published/rejected
- `SpatieMediaLibraryFileUpload` - Media library file upload with visibility config

### Infolists Components

- `CoordinateMap` - Read-only coordinate map display

### Enums

- `PublishStatuses` - Enum with color, icon, and label support for content status

### Traits

- `FilamentAdminUrls` - Generate admin URLs for model records

### Configuration

Added `config/filament-support.php` with modifier toggles:

- `modifiers.forms`
- `modifiers.actions`
- `modifiers.tables`
- `modifiers.infolists`
- `modifiers.summarizers`

All default to `true` and can be disabled via environment variables or config.

### Bug Fixes

- Fixed `hiddenOnRelationManager` loop logic to properly check all relation managers
- Added null safety for enum macros
- Removed dependency on undefined `settings()` helper
