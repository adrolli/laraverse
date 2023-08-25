# Laraverse W-I-P

Laraverse is a project that combines data from Packagist, NPM, GitHub, Gitlab and others to provide a useful search accross the Laravel ecosystem. It is of course made with Laravel, the TALL-Stack including Livewire and Tailwind, and last but not least Filament.

## Install

```shell
gh repo clone adrolli/laraverse
cp .env-example .env
composer install
php artisan migrate:fresh --seed
php artisan queue:work
```

## Model

Not only this shiny model is created with Vemto. The whole app is bootstrapped using [Vemto.app](https.//vemto.app)

![Vemto Model](laraverse_exported_image.png)

## Jobs

Fetching data, calculating and writing even more data to these powerful models is done by jobs:

### PackagistInit

- Get packagist all
- Batch and wait between creating
- PackagistPackage jobs each batch
- Run GithubRepoUpdate for each entry on Github
- do same for GitHub, Gitlab, Bitbucket, Gitea and other repositories

### PackagistPackage

- Check if package exists and timestamp > config-value
- Get full data for package
- Update or create Packagist model

### PackagistUpdater  (runs periodically)

- Get packagist latest by timestamp
- Run PackagistPackage each
- Run GithubRepoUpdate for each entry on Github
- do same for Gitlab, Bitbucket, Gitea and other repositories

### GithubSearch

- Get data from GitHub API by tag or other search
- Create a GithubRepo Job each result

### GithubRepo

- Check if repo exists and timestamp > config-value
- Get full repo data from GitHub API
- Inspect files
  - Readme
  - ServiceProvider
  - Artisan command
  - Composer.json
  - Package.json
  - license
  - Env example
- Update or Create Repository
  - Compatibility
  - Package type

### NpmInit

- Scan all Repositories for package.json dependencies
- Run a NpmPackage each

### NpmPackage

- Gets a package 
- Updates a package

### Item

- Does complex things like compatibility checks, building versions, preparing relations
- Updates a single Item and all related models

### Watcher (runs periodically)

- Watch for changes in Npm, Repository databases 
- or picks entries based on last update timestamp
  - High Popularity ( > 75 ) -> daily
  - Medium Popularity ( > 50 ) -> weekly
  - Low Popularity ( <= 50 ) -> monthly
- Runs the update jobs NpmPackage, GithubRepo and others accordingly
- Possible also for packagist, but using their API seems much more efficient

## Commands

These commands can be used to run jobs manually:

- InitNpm
- InitPackagist
- UpdatePackagist
- GithubSearch - has parameters like tag or search 
- Watcher

## DB Updates

- Vendor 
  - Type: Organization, Developer
- Item
- Github -> Repositories
  - RepositoryType TEXT (Github, Gitlab, Gitea, Bitbucket, other)
  - Compatibility TEXT (PHP Compatible, Laravel Compatible, Compatibility unknown, Not compatible)
  - Package type TEXT (Laravel app, Laravel skeleton, PHP package, NPM package, Other package)
  - Readme (md - how to store and display)
  - Code analyzer JSON
  - License TEXT - detected
  - Composer JSON
  - Package JSON

## Config

- Laravel compatibility: "9, 10"
- PHP compatibility: "8.1, 8.2"
- Known Packages list
- Array of update interval to popularity for different apis

## Todo

-   NPM - https://api-docs.npms.io/ or directly https://stackoverflow.com/questions/34071621/query-npmjs-registry-via-api ... step by step https://www.edoardoscibona.com/exploring-the-npm-registry-api
-   More APIs and maybe some tweaks ... Laracasts, Codecourse, Laravel-Daily, Laravel-News, YT, VS Code Marketplace and many more waiting ...

### Reading from Packagist

-   Packagist API - https://packagist.org/search.json?q=laravel, see https://packagist.org/apidoc oder am besten alles: https://packagist.org/packages/list.json
-   

https://laraverse.test/packagist-search

-   [ ] populate the Packagist table, update then
-   [ ] create item and all related objects if not exists (packagist url and ID in packagist table), compare and update a bunch of fields then

### Reading from NPM

-   [ ] populate the NPM table, update then
-   [ ] create item and all related objects if not exists (npm url and ID in npm table), compare and update a bunch of fields then

### Reading from GitHub

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

https://laraverse.test/github-search/laravel

-   [ ] populate the Github table and all related, update then
-   [ ] create item and all related objects if not exists (github url and ID in github table), compare and update a bunch of fields then

## Create Items

Creating Items should be done by merging all datasets into the items model including all relations. Following rules apply:

- From Packagist

  - Fill title

  - Fill slug

  - Fill description

  - Fill latest version

  - Form versions json

  - Create vendor

    - ... data

  - Fill website

  - Calc and set popularity to ...

    - Rating
    - Form rating data (json)
    - Health
    - Form health data (json)

  - Fill Packagist url

    Fill Packagist name

    Fill Packagist description

    Fill Packagist downloads

    Fill Packagist favers

  - Fill Github repo - this is the sign for the Github Consumer to fetch this package, as all (or some special) other GitHub fields are empty

  - Item type = composer-package

  - Platform = php-package (is there sth to differentiate, because there are composer texts...?)

  - Categories = let's see

  - Tags = let's see

  - Item Relation ... that will be harder work

    - composer_suggest
    - composer_provide
    - composer_replace
    - composer_conflict
    - composer_require_dev
    - composer_require

  - Create Packagist Relation

## Taxonomies

-   Area

    -   Backend Framework
    -   Frontend Framework
    -   Middleware
    -   API Generator
    -   Authentication and User
    -   Deployment Platform
    -   Component Framework
    -   Development Framework
    -   CRUD Generator
    -   Tooling ...
    -   Webserver
    -   Webproxy
    -   Accelerator
    -   Cache
    -   Database
    -   Hosting
    -   Cloud
    -   Code Upgrader
    -   IDE
    -   VCS
    -   Devops ...

-   Type

    -   PHP Package
    -   PHP Skeleton
    -   PHP App
    -   IDE Extension
    -   Windows App
    -   MacOS App
    -   Linux App
    -   PHP Extension
    -   Webserver
    -   Web Platform
    -   Web API
    -   NPM Package
    -   Other Package
    -   Other App
    -   Other

-   Pricing

    -   FOSS - Free Open Source Software.
    -   OSS - Open Source Code but not free.
    -   SaaS - Commercial Software as a Service product.
    -   Libre - Free Software as a Service product.
    -   Shareware - Free but not Open Source Software.
    -   Freemium - Commercial product with a free version.
    -   Commercial - Commercial product with one-time fee or lifetime license.
    -   Subscription - Commercial product with perpetual costs.

-   Features (aka Tags) ... can probably be grouped or aliased
    -   Authentication
    -   Authorization
    -   User management
    -   User profile
    -   User registration
    -   ...

## MySQL Problem

The app has pretty large models including fat json data. If you encounter the error: ```SQLSTATE[HY001]: Memory allocation error: 1038 Out of sort memory, consider increasing server sort buffer size``` it is probably related to this MySQL bug: https://bugs.mysql.com/bug.php?id=103318 and can be fixed by `SET GLOBAL sort_buffer_size = 256000000 // It'll reset after server restart`, see https://stackoverflow.com/questions/29575835/error-1038-out-of-sort-memory-consider-increasing-sort-buffer-size or https://www.educba.com/mysql-sort-buffer-size/ for persistence or remove the JSON fields from the table views like so:

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



## Backlog

-   Stack-Installer ... is it possible to combine all install commands automagically to an "installer"? Like laravel.build
-   Receipes and compatibility checks (people can check a stack compat)
-   Stack the big picture ... see the stack as a fancy image or do sth markdownish to go viral ;-)
-   Safe stack ... how safe (active dev, bottlenecks) is your stack?
-   Books, Video Courses, Learning platforms as new types
-   Packalyst RSS - https://packalyst.com/resources (new and requested)
-   User-driven, v. a. Rating für Sortierung, Posts (Request, Recipe, ...)
-   Blog, aggregation
-   Generated newsletter
-   https://filamentphp.com/plugins/leandrocfe-apex-charts
-   https://filamentphp.com/plugins/pxlrbt-spotlight
-   Export / Import / User (with Impersonate)
-   https://filamentphp.com/plugins/awcodes-overlook
-   https://filamentphp.com/plugins/bezhansalleh-exception-viewer
-   Filament V3
-   https://gitlab.com/amvisor/filament-failed-jobs -> nav pos
-   https://github.com/croustibat/filament-jobs-monitor -> nav pos, jobs done instead of current, or pending ... missing view
-   Supervisor or cron (much easier) for Managing and self-healing the Job Queue: https://gist.github.com/deepak-cotocus/6b9865784dee18966e15c74ec6e487c4
-   Better display JSON in Filament: https://github.com/invaders-xx/filament-jsoneditor
-   Fiddle with OpenAI: https://github.com/openai-php/laravel
-   Make something for health ... add monitors ... https://filamentphp.com/plugins/shuvroroy-spatie-laravel-health
