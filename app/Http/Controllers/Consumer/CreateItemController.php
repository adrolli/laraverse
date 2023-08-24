<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;

class CreateItemController extends Controller
{
    public function wellKnownPackages()
    {
        $wellKnownPackages = [
            'php' => '8.0.0',
            'laravel/framework' => '9.0',
            'barryvdh/laravel-debugbar' => '4.0',
            'beyondcode/laravel-dump-server' => '2.0',
            'doctrine/orm' => '3.0',
            'fakerphp/faker' => '1.0',
            'filament/filament' => '1.0',
            'filp/whoops' => '3.0',
            'fruitcake/laravel-cors' => '2.0',
            'guzzlehttp/guzzle' => '7.0',
            'illuminate/support' => '9.0.0',
            'illuminate/http' => '9.0.0',
            'illuminate/database' => '9.0.0',
            'illuminate/notifications' => '9.0.0',
            'illuminate/view' => '9.0.0',
            'illuminate/validation' => '9.0.0',
            'illuminate/translation' => '9.0.0',
            'illuminate/testing' => '9.0.0',
            'illuminate/session' => '9.0.0',
            'illuminate/routing' => '9.0.0',
            'inertiajs/inertia-laravel' => '0.11',
            'intervention/image' => '3.0',
            'laravel/broadcasting' => '4.0',
            'laravel/breeze' => '2.0',
            'laravel/passport' => '12.0',
            'laravel/ui' => '3.0',
            'livewire/livewire' => '2.0',
            'nikic/php-parser' => '4.0',
            'nunomaduro/collision' => '6.0',
            'phpunit/phpunit' => '9.5',
            'ramsey/uuid' => '4.0',
            'silber/bouncer' => '2.0',
            'silber/page-cache' => '2.0',
            'spatie/laravel-medialibrary' => '9.0',
            'spatie/laravel-backup' => '7.0',
            'spatie/laravel-query-builder' => '4.0',
            'spatie/laravel-activitylog' => '4.0',
            'spatie/laravel-sluggable' => '4.0',
            'spatie/laravel-permission' => '4.0',
            'symfony/console' => '5.0',
            'symfony/http-foundation' => '5.0',
            'swiftmailer/swiftmailer' => '7.0',
        ];

        return $wellKnownPackages;
    }

    public function doCompatibilityChecks()
    {

        $wellKnownPackages = $this->wellKnownPackages();

        // Fetch package information from Packagist API
        $vendor = 'vendor-name';
        $packageName = 'package-name';
        $response = Http::get("https://packagist.org/packages/{$vendor}/{$packageName}.json");
        $packageInfo = $response->json();

        $isCompatible = false;

        foreach ($wellKnownPackages as $package => $compatibleVersion) {
            if (
                isset($packageInfo['package']['require'][$package]) &&
                version_compare($packageInfo['package']['require'][$package], $compatibleVersion, '>=')
            ) {
                $isCompatible = true;
                break; // No need to continue checking
            }
        }

        if (isset($wellKnownPackages[$packageName])) {
            $isCompatible = true;
        }

        if ($isCompatible) {
            // Package is compatible with PHP 8.0 or Laravel 9.0 (or their compatible well-known packages)
        } else {
            // Package is not compatible
        }

    }

    public function readPackagistJson()
    {

    }
}
