<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laraverse</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @livewireStyles

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased">

        <div class="m-5">
            <div class="flex">
                <div class="m-10">
                    <h2 class="pt-5 pb-1 text-lg">Live</h2>
                    <ul>
                        <li><a href="http://128.140.40.223/" target="_blank">Homepage</a></li>
                        <li><a href="http://128.140.40.223/admin/" target="_blank">Admin</a></li>
                        <li><a href="http://128.140.40.223/dev?token={{env('LARAVERSE_TOKEN')}}" target="_blank">Dev</a></li>
                        <li><a href="http://128.140.40.223/horizon" target="_blank">Horizon</a></li>
                    </ul>
                </div>
                <div class="m-10">
                    <h2 class="pt-5 pb-1 text-lg">Beta</h2>
                    <ul>
                        <li><a href="https://laraverse.dev/" target="_blank">Homepage</a></li>
                        <li><a href="https://laraverse.dev/admin" target="_blank">Admin</a></li>
                        <li><a href="https://laraverse.dev/dev?token={{env('LARAVERSE_TOKEN')}}" target="_blank">Dev</a></li>
                    </ul>
                </div>
                <div class="m-10">
                    <h2 class="pt-5 pb-1 text-lg">Dev</h2>
                    <ul>
                        <li><a href="https://laraverse.test/" target="_blank">Homepage</a></li>
                        <li><a href="https://laraverse.test/admin" target="_blank">Admin</a></li>
                        <li><a href="https://laraverse.test/dev?token={{env('LARAVERSE_TOKEN')}}" target="_blank">Dev</a></li>
                    </ul>
                </div>
            </div>
            <div class="m-10">
                <h2 class="pt-5 pb-1 text-lg">Devops</h2>

                <div class="flex">
                    <ul class="m-10">
                        <li><a href="https://forge.laravel.com/servers/718293/sites/2103786/application" target="_blank">Laravel Forge</a></li>
                        <li><a href="https://envoyer.io/projects/108109#/recent-deployments" target="_blank">Envoyer</a></li>
                        <li><a href="https://github.com/adrolli/laraverse/" target="_blank">GitHub</a></li>
                    </ul>
                    <ul class="m-10">
                        <li><a href="https://dashboard.algolia.com/apps/2CKD14126J/explorer/browse/packagist_packages?searchMode=search" target="_blank">Algolia</a></li>
                        <li><a href="https://app.mailersend.com/domains/3vz9dle01wngkj50" target="_blank">Mailersend</a></li>
                        <li><a href="https://console.hetzner.cloud/projects/2557394/servers/37180469/overview target="_blank">Hetzner Cloud</a> (ssh forge@128.140.40.223)</li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>



