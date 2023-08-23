# Laraverse

Laraverse ist mein Favorit, wenn das Projekt nur um Laravel geht, Larapedia, Laravault, Explore Laravel, Laraworld, Discover Laravel und Larastack wären die Alternativen. Weiter gedacht könnte auch StackSearch, StackBuilder, Stackalizer, TechStax infrage kommen. Alternativ etwas was PHP und JS verbindet, Ableger für WP und dergleichen.


Jedenfalls gibt es keine gute Suche für Laravel Packages. Wenn, dann sind es nur Packages, Tools wie Vemto findet man nicht.

## Model

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

![Vemto Model](laraverse_exported_image.png)

## Todo

Laravel is accessible, powerful, and provides tools required for large, robust applications.

-   NPM - https://api-docs.npms.io/ or directly https://stackoverflow.com/questions/34071621/query-npmjs-registry-via-api ... step by step https://www.edoardoscibona.com/exploring-the-npm-registry-api
-   More APIs and maybe some tweaks ... Laracasts, Codecourse, Laravel-Daily, Laravel-News, YT, VS Code Marketplace and many more waiting ...

### Reading from Packagist

-   Packagist API - https://packagist.org/search.json?q=laravel, see https://packagist.org/apidoc oder am besten alles: https://packagist.org/packages/list.json
    Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

https://laraverse.test/packagist-search

-   [ ] populate the Packagist table, update then
-   [ ] create item and all related objects if not exists (packagist url and ID in packagist table), compare and update a bunch of fields then

### Reading from NPM

-   [ ] populate the NPM table, update then
-   [ ] create item and all related objects if not exists (npm url and ID in npm table), compare and update a bunch of fields then
        You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

### Reading from GitHub

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

https://laraverse.test/github-search/laravel

-   [ ] populate the Github table and all related, update then
-   [ ] create item and all related objects if not exists (github url and ID in github table), compare and update a bunch of fields then

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

## Other ideas

-   Stack-Installer ... is it possible to combine all install commands automagically to an "installer"? Like laravel.build
-   Receipes and compatibility checks (people can check a stack compat)
-   Stack the big picture ... see the stack as a fancy image
-   Safe stack ... how safe (active dev, bottlenecks) is your stack?
-   Books, Video Courses, Learning platforms as new types
-   Packalyst RSS - https://packalyst.com/resources (new and requested)
-   eigene Einträge (wie Vemto, Skipper)
-   Packalyst RSS, RSS von Blogs, minimales Scraping
-   User-driven Content.
-   Request (Form, sofortige Veröffentlichung, wenn repo lesbar)
-   Aus der Codebase (v. a. composer.json und package.json)
-   User-driven, v. a. Rating für Sortierung, Posts (Request, Recipe, ...)
-   Anbindung an Laravel-News, Laravel Daily, Laravel.io, X, Stackoverflow, Github Issues und Discussions, etc. um für jedes Tool und Package das meiste an aktuellen Infos anzuzeige



## MySQL Probleme

- Ditch DBngin? 
- SQLSTATE[HY001]: Memory allocation error: 1038 Out of sort memory, consider increasing server sort buffer size 
- Bei Nutzung von JSON Fields, https://bugs.mysql.com/bug.php?id=103318, but should be fixed, see https://stackoverflow.com/questions/71213456/unexpected-behaviour-of-sort-buffer-size-in-mysql-8-0-27-commercial-version
- https://www.educba.com/mysql-sort-buffer-size/ but increasing buffer size is less than a workaround
- Use mysql --socket /tmp/mysql_3306.sock -uroot to connect with DBngin, see https://github.com/TablePlus/DBngin/issues/38
- Probably try Postgre, is it on Forge?
- Probably do a custom query in Filament, excluding the json
- Probably google for other solutions like stored procedures
- Currently brewed MySQL 8.1, use with `mysql -u root - same shit
- But finally working on 8.1: `SET GLOBAL sort_buffer_size = 256000000 // It'll reset after server restart`, see https://stackoverflow.com/questions/29575835/error-1038-out-of-sort-memory-consider-increasing-sort-buffer-size

Trotzdem 

- https://filamentphp.com/docs/2.x/admin/resources/getting-started#customizing-the-eloquent-query
- Am Ende funktioniert es, die JSON resourcen aus der list zu bekommen ... und Mysql gepatcht



## Backlog

- Jobs und Failed Jobs sind zwei Plugins ... mach eines draus und besser konfigurierbar.
  - https://gitlab.com/amvisor/filament-failed-jobs
  - https://github.com/croustibat/filament-jobs-monitor
  - Man sieht die abgearbeiteten Jobs, nicht die current jobs als zähler
  - Man sieht nicht, wie viele Jobs anstehen
- Supervisor or cron (much easier) for Managing and self-healing the Job Queue: https://gist.github.com/deepak-cotocus/6b9865784dee18966e15c74ec6e487c4
- Better display JSON in Filament: https://github.com/invaders-xx/filament-jsoneditor
- Fiddle with OpenAI: https://github.com/openai-php/laravel
