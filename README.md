# Consolidation

## Installation

You can install the package via composer:

```bash
composer required imarcom/laravel-consolidation
```

You can publish the config file with:

```
php artisan vendor:publish --provider="Imarcom\Consolidation\ConsolidationServiceProvider" --tag="config"
```

You must add the routes to `routes/web.php`:
```
Route::consolidation();
```