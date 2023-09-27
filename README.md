# Laraverse

Laraverse is work in progress. It will become

... a project that combines data from Packagist, NPM, GitHub, Gitlab and others to provide a useful search across the Laravel ecosystem. It is made with Laravel, the TALL-Stack including Livewire, Alpine and TailwindCSS, and last but not least Filament.

## Installation

```shell

gh repo clone adrolli/laraverse
cp .env-example .env
composer install

# seeding installs filament demo-data
# and admin@admin.com:admin as superuser
php artisan migrate:fresh --seed

# If not using Redis as backend for queues
php artisan queue:table
php artisan queue:failed-table
php artisan queue:batches-table
php artisan migrate

# Do not run queue:work if seeded with lorem ipsum
# use laraverse.gz sql-file to tinker with dev-data
php artisan queue:work


# Now run the Worker Jobs hourly, not all at same time
```

-   Frontend: https://laraverse.test
-   Filament: https://laraverse.test/admin
-   Develop: https://laraverse.test/dev

## The Tech-Stack:

-   Laravel v10
-   Livewire v3
-   AlpineJS v3
-   Tailwind v3
-   Filament v3

## The Plugins

-   bezhansalleh/filament-shield
-   jeffgreco13/filament-breezy
-   pxlrbt/filament-spotlight
-   adrolli/filament-spatie-laravel-activitylog
-   adrolli/filament-job-manager
-   husam-tariq/filament-database-schedule

## The Tooling:

-   [TallUI VS Code Extensions](https://github.com/adrolli/tallui-vscode)
-   [Vemto.app](https://vemto.app)
-   [Laravel Forge](https://forge.laravel.com)
-   [Hetzner Cloud](https://hetzner.com)

## The Model

Not only this shiny model is created with Vemto. The whole app is bootstrapped using [Vemto.app](https.//vemto.app). I use a patched version of the https://github.com/adrolli/vemto-filament-plugin, prepared to easily step up to Filament V3.

![Vemto Model](laraverse_exported_image.png)
