# Laravel Packages

-   Laravel Packages - es gibt keine gute Suche
-   Es muss zuerst mal alle Pakete finden und eine Möglichkeit diese zu kuratieren (Kategorie etc.)
-   Es müssen Updates automatisch erfolgen
-   Es muss User-driven Content geben (Rating, Comments, Discussions)
-   Es sollten nicht nur Packages sein, sondern auch Apps, Tooling etc.
-   News, von überall, auch neue Videos, Training, etc.

## Model

![Vemto Model](laraverse_exported_image.png)

## Brand Idee

Nur für Laravel:

-   Larapedia
-   Laraverse
-   Laravault
-   Larafind
-   Explore Laravel
-   Laraworld
-   Discover Laravel
-   Larastack

oder allgemeiner:

-   StackSearch
-   StackBuilder
-   Stackalizer

### Woher Daten?

Im ersten Schritt müsste eine Masse (zwischen 15k und 500k) packages aus Github kommen, dann das Ökosystem und anderes Zeug, damit auch den großen (weitestgehend nutzlosen) Datenbestand qualifizieren.‚

-   Github API (beachte auch alle PHP-Packages, Dependencies)
-   Wettbewerber (initial)
-   Request (Form, sofortige Veröffentlichung aber ungeprüft)
-   eigene Recherche (z. B. von Filament und anderen größeren Laravel-Plattformen)
-   Aus der Codebase (v. a. composer.json und package.json)
-   User-driven, v. a. Rating für Sortierung

### Wettbewerb

-   https://packalyst.com/

### USPs

-   Usability, da fallen alle durch
-   Nicht nur Packages, sondern das ganze Ökosystem
-   Free / Freemium / Paid
-   Suchen für den vorgegebenen Tech-Stack
-   Anbindung an Laravel-News, Laravel Daily, Laravel.io, X, Stackoverflow, Github Issues und Discussions, etc. um für jedes Tool und Package das meiste an aktuellen Infos anzuzeigen

### Todo

-   Github API - try https://github.com/GrahamCampbell/Laravel-GitHub - or do it as GPT
-   Packagist API - https://packagist.org/search.json?q=laravel, see https://packagist.org/apidoc
-   Packalyst RSS - https://packalyst.com/resources (new and requested)
-   NPM - https://api-docs.npms.io/ or directly https://stackoverflow.com/questions/34071621/query-npmjs-registry-via-api
-   Laracasts, Codecourse, Laravel-Daily, Laravel-News, YT, VS Code Marketplace and many more waiting ...

## Devlog

-   Vemto and Filament 2 platform ready
-   https://laraverse.test/github-search/laravel - basic api call done - create and write to github-cache-table
-   https://laraverse.test/packagist-search/tallui - basic api call done - create and write to packagist-cache-table
-   do same for npm
-   create a merge-data-controller that reads from all three tables and merges to item-table, keep track on changes then
-   curated means there are changes locally, that should not be overwritten by the merge
-   prepare your first output

## Github Data

-   Issues / open / Bugs
-   Discussions?
-   License
-   Tags, Category ...
-   Dependencies PHP / JS - from file

## More Data (to find and calc)

-   Actively Maintained
-   Number of regul. devs
-   Finance
    -   Finance good / OK / poor / unknown
    -   Should be a textual information, too ... company behind or backed by ...
-   Age (first released)
-   Future ... Versions, Roadmap, other?
-   Books ...
-   Videos, Courses (YT, Laracasts, Codecourse, others)
-   Docs (link, per version)
-   Discussions (GH, Stackoverflow, Laravel.io ..., per Version?) and probably an own Forum

## Own Data

-   Likes, Comments, Ratings, Discussions ...
-   Stacks (public)

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

## Handling versions

As a relation or within the main table?

-   Versions are problematic
-   The can change things like license, pricing.
-   The can add features or even change type
-   The can even change name, slug (namespace) ...
-   They change dependencies and everything
-   But they should be clearly just a version ...

## Other ideas

-   Stack-Installer ... is it possible to combine all install commands automagically to an "installer"? Like laravel.build
-   Stack the big picture ... see the stack as a fancy image
-   Safe stack ... how safe (active dev, bottlenecks) is your stack?
