# Laraverse

Laraverse is a project that combines data from Packagist, NPM, GitHub, Gitlab and others to provide a useful search accross the Laravel ecosystem. It is of course made with Laravel, the TALL-Stack including Livewire and Tailwind, and last but not least Filament.

## Install

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
```

## Model

Not only this shiny model is created with Vemto. The whole app is bootstrapped using [Vemto.app](https.//vemto.app). I use a patched version of the https://github.com/adrolli/vemto-filament-plugin, prepared to easily step up to Filament V3.

![Vemto Model](laraverse_exported_image.png)

## Packages

-   [x] Installed bezhansalleh/filament-shield
-   [x] Installed jeffgreco13/filament-breezy
-   [x] Installed pxlrbt/filament-spotlight, but shortcuts don't work
-   [x] Forked adrolli/filament-spatie-laravel-activitylog
-   [x] Installed adrolli/filament-job-manager
-   [x] husam-tariq/filament-database-schedule
-   [ ] https://filamentphp.com/plugins/z3d0x-fabricator - test
-   [ ] shuvroroy/filament-spatie-laravel-backup
-   [ ] shuvroroy/filament-spatie-laravel-health
-   [ ] Fork! 3x1io/filament-user
-   [ ] archilex/filament-toggle-icon-column
-   [ ] buildix/timex, test only
-   [ ] invaders-xx/filament-kanban-board, test only
-   [ ] camya/filament-title-with-slug
-   [ ] konnco/filament-import
-   [ ] leandrocfe/filament-apex-charts
-   [ ] pxlrbt/filament-excel
-   [ ] z3d0x/filament-logger

## Jobs

Fetching data, calculating and writing even more data to these powerful models is done by jobs:

### PackagistUpdate (runs hourly, but not concurrent)

Packagist API - https://packagist.org/search.json?q=laravel, see https://packagist.org/apidoc oder am besten alles: https://packagist.org/packages/list.json

-   [ ] Check table for pending updates and collect them in an array

    -   [ ] Item popularity > 75 % should be checked hourly
    -   [ ] Item popularity > 50 % should be checked daily
    -   [ ] Item popularity <= 50% should be checked weekly
    -   [ ] Null or no Item should be checked monthly

-   [x] If table empty get all packages from Packagist
-   [ ] Else get Packagist latest by timestamp of last run
-   [x] Run PackagistPackages in a batch of 100, do a 1 sec sleep between

### PackagistPackagesUpdate

-   [x] Needs an array of packagist packages, so it can do 1 or many packages and are enabled to be used witch batch mode
-   [x] Get full data for package from Packagist API, do a 1 sec sleep between
-   [x] Update or create Packagist model with fields
-   [x] set Repo Updated to false

### RepositoriesUpdater (runs hourly, but not concurrent)

-   [ ] Checks Packagist table for all entries with Repo Updated = false and creates an array
-   [ ] Checks Repositories table for needed updates (set rules) and creates an array
-   [ ] Combine the arrays, remove duplicates, batch 100 and run Repositories

### GithubSearch

-   [ ] Get data from GitHub API by tag or other search
-   [ ] Create a GithubRepo Job each result

### RepositoriesUpdate

-   [ ] Needs an array of repositories, so it can do 1 or many packages and are enabled to be used witch batch mode
-   [ ] Get full repo data from GitHub API, Gitlab, Bitbucket
-   [ ] Inspect files
    -   [ ] Readme
    -   [ ] ServiceProvider
    -   [ ] Artisan command
    -   [ ] Composer.json
    -   [ ] Package.json
    -   [ ] license
    -   [ ] Env example
-   [ ] Update or Create Repository
    -   [ ] Compatibility
    -   [ ] Package type

### NpmInit

-   [ ] Scan all Repositories for package.json dependencies
-   [ ] Run a NpmPackage each

### NpmPackage

NPM - https://api-docs.npms.io/ or directly https://stackoverflow.com/questions/34071621/query-npmjs-registry-via-api ... step by step https://www.edoardoscibona.com/exploring-the-npm-registry-api

-   [ ] Gets a package
-   [ ] Updates a package

### Item

-   [ ] Does complex things like compatibility checks, building versions, preparing relations
-   [ ] Updates a single Item and all related models

### Watcher (runs periodically)

-   [ ] Watch for changes in Npm, Repository databases
-   [ ] or picks entries based on last update timestamp
    -   [ ] High Popularity ( > 75 ) -> daily
    -   [ ] Medium Popularity ( > 50 ) -> weekly
    -   [ ] Low Popularity ( <= 50 ) -> monthly
-   [ ] Runs the update jobs NpmPackage, GithubRepo and others accordingly
-   [ ] Possible also for packagist, but using their API seems much more efficient

## Commands

These commands can be used to run jobs manually:

-   [ ] InitNpm
-   [ ] InitPackagist
-   [x] UpdatePackagist
-   [ ] GithubSearch - has parameters like tag or search
-   [ ] Watcher

## Config

-   [ ] Laravel compatibility: "9, 10"
-   [ ] PHP compatibility: "8.1, 8.2"
-   [ ] Known Packages list
-   [ ] Array of update interval to popularity for different apis
    -   [ ] Update interval
        -   [ ] Packagist

## Create Items

Creating Items should be done by merging all datasets into the items model including all relations. Following rules apply:

-   From Packagist

    -   Fill title

    -   Fill slug

    -   Fill description

    -   Fill latest version

    -   Form versions json

    -   Create vendor

        -   ... data

    -   Fill website

    -   Calc and set popularity to ...

        -   Rating
        -   Form rating data (json)
        -   Health
        -   Form health data (json)

    -   Fill Packagist url

        Fill Packagist name

        Fill Packagist description

        Fill Packagist downloads

        Fill Packagist favers

    -   Fill Github repo - this is the sign for the Github Consumer to fetch this package, as all (or some special) other GitHub fields are empty

    -   Item type = composer-package

    -   Platform = php-package (is there sth to differentiate, because there are composer texts...?)

    -   Categories = let's see

    -   Tags = let's see

    -   Item Relation

        -   composer_suggest
        -   composer_provide
        -   composer_replace
        -   composer_conflict
        -   composer_require_dev
        -   composer_require

    -   Create Packagist Relation

## Taxonomies

- Categories
  - FOSS - Free Open Source Software.
  - OSS - Open Source Code but not free.
  - SaaS - Commercial Software as a Service product.
  - Libre - Free Software as a Service product.
  - Shareware - Free but not Open Source Software.
  - Freemium - Commercial product with a free version.
  - Commercial - Commercial product with one-time fee or lifetime license.
  - Subscription - Commercial product with perpetual costs.
- Tags ... can be called "Features", must be curated, can be grouped or aliased?
  -   Authentication
  -   Authorization
  -   User management
  -   User profile
  -   User registration
  -   ...
- Platforms
  - Laravel Package
  - Laravel Skeleton
  - Laravel App
  - Laravel Template
  - PHP Package
  - PHP Skeleton
  - PHP App
  - PHP Template
  - PHP Extension
  - NPM Package
  - App for Linux
  - App for MacOS
  - App for Windows
  - Software for Linux
  - Software for MacOS
  - Software for Windows
  - Webserver
  - Webserver plugin
  - Website or platform
  - Android App
  - iOS App
  - Browser
  - IDE or Editor
  - IDE Extension
  - Other Package
  - Other App
  - Other
  - Web API
  - GitHub Action
  - Bash-Scripts
  - Python
  - Composer extension
- Item Types
  - Backend Framework
  - Frontend Framework
  - Middleware
  - API Generator
  - Authentication and User
  - Deployment Platform
  - Component Framework
  - Development Framework
  - CRUD Generator
  - Tooling ...
  - Webserver
  - Webproxy
  - Accelerator
  - Cache
  - Database
  - Hosting
  - Cloud
  - Code Upgrader
  - IDE
  - VCS
  - Devops ...

## MySQL Problem

The app has pretty large models including fat json data. If you encounter the error: `SQLSTATE[HY001]: Memory allocation error: 1038 Out of sort memory, consider increasing server sort buffer size` it is probably related to this MySQL bug: https://bugs.mysql.com/bug.php?id=103318 and can be fixed by `SET GLOBAL sort_buffer_size = 256000000 // It'll reset after server restart`, see https://stackoverflow.com/questions/29575835/error-1038-out-of-sort-memory-consider-increasing-sort-buffer-size or https://www.educba.com/mysql-sort-buffer-size/ for persistence or remove the JSON fields from the table views like so:

```php
namespace App\Filament\Resources\PackagistPackageResource\Pages;

use ...

class ListPackagistPackages extends ListRecords
{
		...

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()->select('id', 'title', 'slug');
    }
}

```

## Optimizing Jobs

Jobs are failing, that's OK, but some Jobs do kill the Queue, that's not OK.

   Symfony\Component\ErrorHandler\Error\FatalError

  Allowed memory size of 134217728 bytes exhausted (tried to allocate 4096 bytes)

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Casts/Json.php:36
     32▕     public static function decode(mixed $value, ?bool $associative = true): mixed
     33▕     {
     34▕         return isset(static::$decoder)
     35▕                 ? (static::$decoder)($value, $associative)
  ➜  36▕                 : json_decode($value, $associative);
     37▕     }
     38▕
     39▕     /**
     40▕      * Encode all values using the given callable.


   Whoops\Exception\ErrorException

  Allowed memory size of 134217728 bytes exhausted (tried to allocate 4096 bytes)

  at vendor/laravel/framework/src/Illuminate/Database/Eloquent/Casts/Json.php:36
     32▕     public static function decode(mixed $value, ?bool $associative = true): mixed
     33▕     {
     34▕         return isset(static::$decoder)
     35▕                 ? (static::$decoder)($value, $associative)
  ➜  36▕                 : json_decode($value, $associative);
     37▕     }



## Backlog

-   https://filamentphp.com/plugins/bezhansalleh-exception-viewer
-   Better display JSON in Filament: https://github.com/invaders-xx/filament-jsoneditor
-   Display Markdown
-   Awesome Lists, Items that needs to be there
-   Fiddle with OpenAI: https://github.com/openai-php/laravel
-   Make something for health ... add monitors ... https://filamentphp.com/plugins/shuvroroy-spatie-laravel-health

