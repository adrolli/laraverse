<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laraverse'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'https://laraver.se'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\HorizonServiceProvider::class,
        App\Providers\Filament\AdminPanelProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Laraverse Settings
    |--------------------------------------------------------------------------
    |
    | All settings for Laraverse should be handled by config but normally
    | provided by .env, so all is cacheable and adjustable per platform.
    |
    */

    'laraverse_token' => env('LARAVERSE_TOKEN', 'laraverse'),
    'laraverse_tries' => env('LARAVERSE_TRIES', 3),
    'laraverse_timeout' => env('LARAVERSE_TIMEOUT', 60),
    'laraverse_exceptions' => env('LARAVERSE_EXCEPTIONS', 1),
    'laraverse_backoff' => env('LARAVERSE_BACKOFF', 120),
    'laraverse_batch' => env('LARAVERSE_BATCH', 25),

    'laraverse_github_pages' => env('LARAVERSE_GITHUB_PAGES', 25),

    'laraverse_api_web' => env('LARAVERSE_API_WEB'),
    'laraverse_api_identifier' => env('LARAVERSE_API_IDENTIFIER'),
    'laraverse_api_mail' => env('LARAVERSE_API_MAIL'),

    'github_api_token' => env('GITHUB_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Laraverse Known Packages
    |--------------------------------------------------------------------------
    |
    | The known packages are scaffolded here to allow the jobs to find
    | packages and apps, compatible to a spedific stack and version.
    |
    */

    'compatibility' => [

        'php' => [
            'latest' => '8.2',
            'versions' => [
                '8.2',
                '8.1',
                '8.0',
                '7.4',
                '7.3',
                'unknown',
            ],
            'packages' => [
                'laravel/framework' => 'v10.0.0',
                'illuminate/auth' => 'v10.0.0',
                'illuminate/support' => 'v10.0.0',
                'illuminate/database' => 'v10.0.0',
                'illuminate/contracts' => 'v10.0.0',
                'illuminate/container' => 'v10.0.0',
                'illuminate/view' => 'v10.0.0',
                'illuminate/validation' => 'v10.0.0',
                'illuminate/session' => 'v10.0.0',
                'illuminate/queue' => 'v10.0.0',
                'illuminate/pipeline' => 'v10.0.0',
                'illuminate/macroable' => 'v10.0.0',
                'illuminate/http' => 'v10.0.0',
                'illuminate/filesystem' => 'v10.0.0',
                'illuminate/events' => 'v10.0.0',
                // phpunit etc.
            ],
        ],
        'laravel' => [
            'latest' => '10',
            'versions' => [
                '10',
                '9',
                '8',
                '7',
                '6',
                'unknown',
            ],
            'packages' => [
                'laravel/framework' => 'v10.0.0',
                'illuminate/auth' => 'v10.0.0',
                'illuminate/support' => 'v10.0.0',
                'illuminate/database' => 'v10.0.0',
                'illuminate/contracts' => 'v10.0.0',
                'illuminate/container' => 'v10.0.0',
                'illuminate/view' => 'v10.0.0',
                'illuminate/validation' => 'v10.0.0',
                'illuminate/session' => 'v10.0.0',
                'illuminate/queue' => 'v10.0.0',
                'illuminate/pipeline' => 'v10.0.0',
                'illuminate/macroable' => 'v10.0.0',
                'illuminate/http' => 'v10.0.0',
                'illuminate/filesystem' => 'v10.0.0',
                'illuminate/events' => 'v10.0.0',
                'livewire/livewire' => 'v3.0.0',
                'livewire/volt' => 'v1.0.0',
                'laravel/jetstream' => 'v3.1.0',
                'laravel/breeze' => 'v1.20.0',
                'filament/filament' => 'v3.0.9',
                'spatie/laravel-permission' => 'unknown',
                'fideloper/proxy' => 'unknown',
                'jenssegers/agent' => 'unknown',
                'barryvdh/laravel-ide-helper' => 'unknown',
                'spatie/laravel-package-tools' => 'unknown',
                'spatie/laravel-backup' => 'unknown',
                'spatie/laravel-activitylog' => 'unknown',
                'spatie/eloquent-sortable' => 'unknown',
                'barryvdh/laravel-debugbar' => 'unknown',
                'barryvdh/laravel-ide-helper' => 'unknown',
            ],
        ],
        // shares with tall-stack and ball-stack
        'livewire' => [
            'packages' => [
                'livewire/livewire' => 'v3.0.0',
                'livewire/volt' => 'v1.0.0',
                'laravel/jetstream' => 'v3.1.0',
                'laravel/breeze' => 'v1.20.0',
                'filament/filament' => 'v3.0.9',
                // some more well known livewire
            ],
        ],
        'filament' => [
            'latest' => '3',
            'versions' => [
                '3',
                '2',
                '1',
                'unknown',
            ],
            'packages' => [
                'filament/filament' => 'v3.0.9',
            ],
        ],
        // statamic and more ...
    ],

    /*
    |--------------------------------------------------------------------------
    | Laraverse Packagist Search
    |--------------------------------------------------------------------------
    |
    | This array is for all keyword-based searches, using the PackagistPackages
    | model. Key = search, Content = tags to be set for the Package.
    |
    */

    'packagist_search' => [

        'laravel' => 'php, laravel',
        'eloquent' => 'php, laravel, eloquent',
        'livewire' => 'php, laravel, livewire, tall-stack',
        'tailwind laravel' => 'php, laravel, tailwind',
        'tall' => 'php, laravel, livewire, alpinejs, tailwindcss, tall-stack',
        'tallstack' => 'php, laravel, livewire, alpinejs, tailwindcss, tall-stack',
        'tall-stack' => 'php, laravel, livewire, alpinejs, tailwindcss, tall-stack',
        'filament' => 'php, laravel, livewire, tall-stack, filament, tailwindcss, alpinejs, admin, crud',
        'statamic' => 'php, laravel, statamic, cms',
        'octobercms' => 'php, laravel, october, cms',
        'october' => 'php, laravel, october, cms',
        'asgard' => 'php, laravel, asgard, cms',
        'asgardcms' => 'php, laravel, asgard, cms',
        'winter' => 'php, laravel, winter, cms',
        'wintercms' => 'php, laravel, winter, cms',
        'flarum' => 'php, laravel, flarum, forum',
        'vilt' => 'php, laravel, inertia, vue, tailwind, vilt-stack',
        'rilt' => 'php, laravel, inertia, react, tailwind, rilt-stack',
        'inertia' => 'php, laravel, inertia',
        'laravel nova' => 'php, laravel, nova, admin, crud',
        'spatie/' => 'php, spatie',
        'spatie/laravel' => 'php, laravel, spatie',
        'spatie' => 'php, spatie',
        'lunarphp' => 'php, laravel, lunar, livewire, shop, ecommerce',
        'bagisto' => 'php, laravel, bagisto, shop, ecommerce',
        'vanilo' => 'php, laravel, vanilo, shop, ecommerce',
        'aimeos' => 'php, laravel, aimeos, shop, ecommerce',
        'blade icons' => 'php, laravel, blade, blade-ui-kit, blade-icons',
        'blade ui' => 'php, laravel, blade, blade-ui-kit, blade-icons',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laraverse Packagist Tags
    |--------------------------------------------------------------------------
    |
    | This array is for all tag-based searches, using the Packagist API
    | Key = tag (API), Content = tags to be set for the Package.
    |
    */

    'packagist_tags' => [

        'laravel' => 'php, laravel',
        'eloquent' => 'php, laravel, eloquent',
        'livewire' => 'php, laravel, livewire, tall-stack',
        'tailwind laravel' => 'php, laravel, tailwind',
        'tall' => 'php, laravel, livewire, alpinejs, tailwindcss, tall-stack',
        'tallstack' => 'php, laravel, livewire, alpinejs, tailwindcss, tall-stack',
        'tall-stack' => 'php, laravel, livewire, alpinejs, tailwindcss, tall-stack',
        'filament' => 'php, laravel, livewire, tall-stack, filament, tailwindcss, alpinejs, admin, crud',
        'statamic' => 'php, laravel, statamic, cms',
        'octobercms' => 'php, laravel, october, cms',
        'october' => 'php, laravel, october, cms',
        'asgard' => 'php, laravel, asgard, cms',
        'asgardcms' => 'php, laravel, asgard, cms',
        'winter' => 'php, laravel, winter, cms',
        'wintercms' => 'php, laravel, winter, cms',
        'flarum' => 'php, laravel, flarum, forum',
        'vilt' => 'php, laravel, inertia, vue, tailwind, vilt-stack',
        'rilt' => 'php, laravel, inertia, react, tailwind, rilt-stack',
        'inertia' => 'php, laravel, inertia',
        'laravel nova' => 'php, laravel, nova, admin, crud',
        'spatie/' => 'php, spatie',
        'spatie/laravel' => 'php, laravel, spatie',
        'spatie' => 'php, spatie',
        'lunarphp' => 'php, laravel, lunar, livewire, shop, ecommerce',
        'bagisto' => 'php, laravel, bagisto, shop, ecommerce',
        'vanilo' => 'php, laravel, vanilo, shop, ecommerce',
        'aimeos' => 'php, laravel, aimeos, shop, ecommerce',
        'blade icons' => 'php, laravel, blade, blade-ui-kit, blade-icons',
        'blade ui' => 'php, laravel, blade, ui',
        'laravel blade' => 'php, laravel, blade',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laraverse GitHub Search
    |--------------------------------------------------------------------------
    |
    | This array is for all keyword-based searches, using the GitHub Search
    | API. Key = search, Content = tags to be set for the Package.
    | Due to API limits currently only 30 keywords please.
    |
    */

    'github_search' => [
        'filamentphp',
        'filament',
        'statamic',
        'laravel',
        'flarum',
        'livewire',
        'octobercms',
        /*
        https://github.com/search?q=laravel&type=repositories = 566k repos
        https://github.com/search?q=filament&type=repositories = 3k
        https://github.com/search?q=livewire&type=repositories = 8.1k
        https://github.com/search?q=statamic&type=repositories = 1k
        https://github.com/search?q=octobercms&type=repositories = 1k
        https://github.com/search?q=flarum&type=repositories = 1k
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Laraverse GitHub Monitor
    |--------------------------------------------------------------------------
    |
    | This array is for all people and organisations, that should be monitored
    | monitored for new repositories. They will be fetched regularly.
    |
    */

    'github_monitor' => [
        /*
        - laravel
        - illuminate
        - spatie
        - livewire
        - barryvdh
        - flarum
        - nahid
        - thedevdojo
        - z-song
        - octobercms
        */
    ],
];

/*




*/
