# Laravel CRUD Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aytacmalkoc/laravel-crud-generator.svg?style=flat-square)](https://packagist.org/packages/aytacmalkoc/laravel-crud-generator)
[![Total Downloads](https://img.shields.io/packagist/dt/aytacmalkoc/laravel-crud-generator.svg?style=flat-square)](https://packagist.org/packages/aytacmalkoc/laravel-crud-generator)

This package provides a single command to create all CRUD operations in Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require aytacmalkoc/laravel-crud-generator
```

## Usage

```php
php artisan make:crud Product
```

## Generated files

| Controllers       | Requests        | Models  | Observers       | Factories      | Migrations            | Seeders       | Views                           | Routes  |
|-------------------|-----------------|---------|-----------------|----------------|-----------------------|---------------|---------------------------------|---------|
| ProductController | ProductRequests | Product | ProductObserver | ProductFactory | create_products_table | ProductSeeder | index, show, edit, create files | web.php |

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email desgaytacmalkoc@gmail.com instead of using the issue tracker.

## Credits

-   [Aytac Malkoc](https://github.com/aytacmalkoc)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
