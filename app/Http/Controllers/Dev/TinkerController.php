<?php

/*
|--------------------------------------------------------------------------
| Laraverse Tinker Controller
|--------------------------------------------------------------------------
|
| Test things here ...
|
*/

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Traits\Github\GetDatabase;
use App\Traits\Github\GetRateLimits;
use App\Traits\Github\GetRepository;
use App\Traits\Github\GetSearch;
use App\Traits\Github\GetSearchesInQueue;
use App\Traits\Github\GetSearchNext;
use App\Traits\Github\SearchQueries;
use App\Traits\Github\ShowRateLimits;
use App\Traits\Packagist\GetApiAll;
use App\Traits\Packagist\GetApiUpdates;
use App\Traits\PackagistItem\GetLatest;
use App\Traits\PackagistItem\GetPackage;
use App\Traits\PackagistItem\GetVersion;
use App\Traits\PackagistItem\GetVersions;
use Illuminate\Queue\SerializesModels;

class TinkerController extends Controller
{
    //use GetApiAll, GetApiUpdates, GetDatabase, SerializesModels;
    //use GetLatest, GetPackage, GetVersion, GetVersions;
    use GetDatabase, GetRateLimits, GetRepository, GetSearch, GetSearchesInQueue,
        GetSearchNext, SearchQueries, ShowRateLimits;

    public $batch;

    public $slug;

    public function __invoke()
    {
        $secretToken = config('app.laraverse_token');

        if (request('token') !== $secretToken) {
            activity()->log('Unauthorized tinker request');

            abort(403, 'Unauthorized');
        }

        $this->batch = config('app.laraverse_batch');

        $this->tinkerNow();
    }

    public function tinkerNow()
    {

        // Todo: adjust locktime to jobtime
        $perPage = config('app.laraverse_github_pages');

        $pagesInQueue = $this->getGitHubSearchesInQueue();

        $rates = $this->getGithubRateLimits();

        $currentLimits = $rates['search']['remaining'];

        if ($currentLimits >= 1 and $pagesInQueue == true) {

            $this->getGitHubSearchNext($perPage);

            activity()->log('GitHub Search Pages ran successfully');

            // Todo: automize 30 from config
        } elseif ($currentLimits >= 30 and $pagesInQueue == false) {

            $this->getGitHubSearch();

            activity()->log('GitHub Search ran successfully');

        } elseif ($pagesInQueue == true) {

            activity()->log("GitHub Search has only {$currentLimits} left for doing pages");

        } elseif ($pagesInQueue == false) {

            activity()->log("GitHub Search has only {$currentLimits} left for doing searches");

        }

    }

    public function packageData()
    {
        // Packagist Items

        $packageData = $this->getPackage($this->slug);

        echo 'Start job for: '.$packageData['repository'].'<br>';

        $versions = $packageData['versions'];

        $versionsData = $this->getVersions($versions);

        $latest = $this->getLatest($versionsData);

        if ($latest['release']) {
            $latest = $latest['release'];
        } else {
            $latest = $latest['branch'];
        }

        if ($versions[$latest]) {
            var_dump($versions[$latest]['require']);
        }

        /*
         * - Create a tagging Job from here // use own data!!!
         *   - https://packagist.org/search.json?q=laravel
         *   - https://packagist.org/search.json?tags=laravel
         *
         * - Filament Compatibility
         *   - https://packagist.org/search.json?tags=filament
         *   - https://packagist.org/search.json?tags=filamentphp
         *   - https://packagist.org/search.json?q=filament
         *   - https://packagist.org/search.json?q=filamentphp
         *   - https://github.com/search?type=repositories&q=filament
         *   - https://github.com/search?type=repositories&q=filamentphp
         *   - https://github.com/topics/filament
         *   - https://github.com/topics/filamentphp
         *   - https://github.com/filamentphp
         *   - https://filamentphp.com/plugins
         *   - 3
         *   - 2
         *   - 1
         *   - unknown
         * - Livewire Compatibility
         *   - 3
         *   - 2
         *   - 1
         *   - unknown
         * - Tall-Stack
         * - Is Spatie related?
         *   - Spatie
         *   - Related
         * - Inertia (Vilt)
         *   - https://github.com/search?type=repositories&q=vilt-stack
         * - Inertia (Rilt)
         * - Statamic
         *   - https://packagist.org/search.json?q=statamic
         *   - https://statamic.com/addons
         * - October
         *   - https://github.com/search?type=repositories&q=octobercms
         *   - https://github.com/topics/octobercms
         *   - https://github.com/topics/october
         *   - https://octobercms.com/plugins
         * - WinterCMS
         *   - https://github.com/wintercms/awesome-wintercms#plugins
         *   - https://wintercms.com/marketplace
         *   - https://packagist.org/search.json?q=wintercms
         * - Nova
         * - Flarum
         * - Ball-Stack (Bootstrap, not so popular)
         *
         * - see config
         * - Closed source? Like
         *   - https://www.laraship.com/
         *   - https://daalder.io/
         *   - https://www.contentful.com/
         *
         */

        /*
        * Github Searches
        * - https://github.com/search?type=repositories&q=Laravel
        * - https://github.com/search?type=repositories&q=Flarum
        * - https://github.com/search?type=repositories&q=Statamic
        * - https://github.com/search?type=repositories&q=Eloquent
        * - https://github.com/search?type=repositories&q=inertiajs (all Laravel?)
        * - https://github.com/search?type=repositories&q=spatie (some PHP only)
        * - https://github.com/search?type=repositories&q=rilt-stack
        * - https://github.com/search?type=repositories&q=laravel-nova // https://github.com/search?type=repositories&q=laravel+nova
        *
        * Github Topics
        * - https://github.com/topics/laravel
        * - https://github.com/topics/filament
        * - https://github.com/topics/statamic

        * - https://github.com/topics/eloquent
        * - https://github.com/topics/blade
        * - https://github.com/topics/livewire
        * - https://github.com/topics/laravel-livewire
        * - https://github.com/topics/laravel-nova
        * - https://github.com/topics/flarum
        * - https://github.com/topics/tall-stack
        * - https://github.com/topics/tallstack
        * - https://github.com/topics/tall
        * - https://github.com/topics/alpinejs
        * - https://github.com/topics/alpine-js
        * - https://github.com/topics/inertiajs
        * - https://github.com/topics/spatie
        * - https://github.com/topics/vilt-stack
        * - Inertia, TailwindCSS, Tailwind, Vue, React are to broad
        *
        * Github Monitor
        * - spatie/
        * - livewire/
        * - illuminate/
        * - laravel/
        * - barryvdh/
        * - ... you know many more
        */

    }

    /*
    public function tinkerNow()
    {
        activity()->log('Packagist Worker started');

        $batchSize = $this->batch;

        $packagesFromDb = $this->getPackagistPackagesFromDb();
        $packagesFromDbCount = count($packagesFromDb);

        activity()->log('Packagist Worker found '.$packagesFromDbCount.' packages in database');

        $packagesFromApi = $this->getPackagistPackagesFromApi();
        $packagesFromApiCount = count($packagesFromApi);

        activity()->log('Packagist Worker found '.$packagesFromApiCount.' packages in All API');

        $hoursAgo = 1;
        $timestamp = (int) (microtime(true) * 10000) - ($hoursAgo * 60 * 60 * 10000);
        $updatesFromApi = $this->getPackagistUpdatesFromApi($timestamp);
        $updatesFromApiCount = count($updatesFromApi['packagesToCreate']);
        $deletesFromApiCount = count($updatesFromApi['packagesToDelete']);

        activity()->log('Packagist Worker found '.$updatesFromApiCount.' updates and '.$deletesFromApiCount.' deletions in Update API');

        $packagesToCreateFromDb = array_diff($packagesFromApi, $packagesFromDb);
        $packagesToDeleteFromDb = array_diff($packagesFromDb, $packagesFromApi);

        $packagesToCreateFromApi = $updatesFromApi['packagesToCreate'];
        $packagesToDeleteFromApi = $updatesFromApi['packagesToDelete'];

        $packagesToUpdateFromApi = array_intersect($packagesFromDb, $packagesToCreateFromApi);
        $packagesToCreateFromApi = array_diff($packagesToCreateFromApi, $packagesFromDb);

        $packagesToCreate = array_unique(array_merge($packagesToCreateFromDb, $packagesToCreateFromApi));
        $packagesToUpdate = $packagesToUpdateFromApi;
        $packagesToDelete = array_unique(array_merge($packagesToDeleteFromDb, $packagesToDeleteFromApi));

        $this->removeDevBranches($packagesToCreate);
        $this->removeDevBranches($packagesToUpdate);

        $createCount = count($packagesToCreate);
        $updateCount = count($packagesToUpdate);
        $deleteCount = count($packagesToDelete);

        activity()->log('Packagist Worker will create '.$createCount.', update '.$updateCount.' and delete '.$deleteCount.' packages');

        $createChunks = array_chunk($packagesToCreate, $batchSize);

        foreach ($createChunks as $createChunk) {
            PackagistCreate::dispatch($createChunk);
        }

        $updateChunks = array_chunk($packagesToUpdate, $batchSize);

        foreach ($updateChunks as $updateChunk) {
            PackagistUpdate::dispatch($updateChunk);
        }

        $deleteChunks = array_chunk($packagesToDelete, $batchSize);

        foreach ($deleteChunks as $deleteChunk) {
            PackagistDelete::dispatch($deleteChunk);
        }
    }

    // Check if the value contains '~dev'
    public function removeDevBranches(&$array)
    {
        foreach ($array as $key => $value) {
            if (strpos($value, '~dev') !== false) {

                $newValue = str_replace('~dev', '', $value);

                if (array_search($newValue, $array) !== false) {
                    unset($array[$key]);
                } else {
                    $array[$key] = $newValue;
                }
            }
        }
    }
    */
}
