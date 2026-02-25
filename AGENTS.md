# AGENTS.md

This file contains guidelines for agentic coding assistants working in the filament-support repository.

## Development Commands

### Code Formatting
```bash
vendor/bin/pint
composer format
```
Uses Laravel Pint for PHP code style enforcement.

### Testing
```bash
vendor/bin/pest
composer test
```

Run a single test file:
```bash
vendor/bin/pest tests/ExampleTest.php
```

Run a specific test by name:
```bash
vendor/bin/pest --filter "can test"
```

Run tests with coverage:
```bash
vendor/bin/pest --coverage
composer test-coverage
```

### Static Analysis
```bash
vendor/bin/phpstan analyse
composer analyse
```
PHPStan level 5 with Laravel extensions. Includes baseline for existing issues.

## Code Style Guidelines

### Formatting
- **Indentation**: 4 spaces, **Line endings**: LF
- **Trailing whitespace**: Trimmed, **Final newline**: Required
- **Charset**: UTF-8

### PHP Version & Types
- Minimum PHP version: 8.4
- All methods must have return type declarations (void, int, string, etc.)
- Use typed properties and parameters where possible
- Strict types enforced via PHPStan level 5

### Imports & Namespaces
- Use full namespace paths in facades: `\Athphane\FilamentSupport\FilamentSupport::class`
- One `use` statement per line
- Group imports logically: external packages, Laravel, internal
- No leading backslashes in `use` statements

### Naming Conventions
- **Classes**: PascalCase (`FilamentSupport`, `TestCase`)
- **Methods**: camelCase (`getFacadeAccessor`, `setUp`)
- **Properties**: camelCase, **Constants**: UPPER_SNAKE_CASE
- **Files**: PascalCase matching class name

### Class Structure
1. `<?php` tag, 2. Namespace, 3. `use` imports, 4. Docblock (if applicable), 5. Class, 6. Properties, 7. Methods

### Documentation
- PHPDoc blocks for public APIs, `@see` annotations in facades
- Inline comments only when necessary

### Error Handling
- No debugging functions in production code (`dd`, `dump`, `ray`)
- Enforced via Pest Arch tests
- Return appropriate status codes (`self::SUCCESS`, `self::FAILURE`)

### Testing Guidelines
- Uses Pest testing framework (not PHPUnit directly)
- Tests extend `Athphane\FilamentSupport\Tests\TestCase`
- Use Pest's `it()` syntax for test cases
- Use Pest Arch for architecture validation

Example test:
```php
it('can test', function () {
    expect(true)->toBeTrue();
});
```

Architecture test:
```php
arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
```

### Package Structure
- **src/Modifiers/**: Filament component modifiers (Forms, Actions, Tables, Infolists, Summarizers)
- **src/Traits/**: Reusable traits for Filament models
- **src/Commands/**: Artisan commands
- **src/Facades/**: Facade classes
- **tests/**, **config/**, **database/**, **resources/**: Standard Laravel package directories
- **Autoloading**: PSR-4 via composer

### Filament-Specific Patterns
- Modifier classes use `configureUsing()` callbacks to apply default behavior
- Macros registered in static `call()` methods
- Follow Filament's component naming and configuration patterns
- Use Filament's native type hints for components

Example modifier:
```php
<?php

namespace Athphane\FilamentSupport\Modifiers;

use Filament\Forms\Components\TextInput;

class FilamentForms
{
    public static function call(): void
    {
        TextInput::configureUsing(function (TextInput $textInput): void {
            $textInput->dehydrateStateUsing(fn (?string $state): ?string => is_string($state) ? Str::trim($state) : $state);
        });
    }
}
```

### Service Provider
Use Spatie's `PackageServiceProvider`:
- `hasConfigFile()`, `hasViews()`, `hasMigration()`, `hasCommand()`

### Before Committing
ALWAYS run:
1. `vendor/bin/pint` - Format code
2. `vendor/bin/phpstan analyse` - Static analysis
3. `vendor/bin/pest` - Run tests

### CI/CD
- Tests run on PHP 8.3 and 8.4 with Laravel 11 and 12
- PHPStan checks on every PHP file change
- Laravel Pint automatically fixes style issues on push
