# Consolidation

## Installation

You can install the package via composer by adding the repository and the required-dev:

```json
{
    "require-dev": {
        "imarcom/laravel-consolidation": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@bitbucket.org:imarcom/laravel-consolidation.git"
        }
    ]
}
```

You can publish the config file with:

```
php artisan vendor:publish --provider="Imarcom\Consolidation\ConsolidationServiceProvider" --tag="config"
```

You must add the routes to `routes/web.php`:
```
Route::consolidation();
```