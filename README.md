# MaskMan

```php
use Cluedit\MaskMan;

// Convert all key in array from camelCase to snake_case.
$newArray = MaskMan::convert($array)->to('snake_case');
// or
$maskMan = new MaskMan($array);
$newArray = $maskman->to('snake_case');

// Convert all key in array from snake_case to camelCase.
$newArray = MaskMan::convert($array)->to('camelCase');
// or
$maskMan = new MaskMan($array);
$newArray = $maskman->to('camelCase');

// Convert all key in array from snake_case to PascalCase by a anomymous function.
$newArray = MaskMan::convert($array)->by('PascalCase', function(string $string) {
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
})->to('PascalCase');
// or
$maskMan = new MaskMan($array);
$newArray = $maskMan->by('Pascal', function(string $string) {
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
})->to('PascalCase');
```

## Installation

### With Composer

```bash
composer require cluedit/maskman
```

```json
{
    "require": {
        "cluedit/maskman": "~1.0"
    }
}
```

## With Laravel Eloquent: API Resources

```php
```