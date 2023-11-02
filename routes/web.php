<?php

use App\Http\Controllers\Artisan\QueueWorker;
use App\Http\Controllers\Artisan\Scheduler;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dev\TinkerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemRelationController;
use App\Http\Controllers\ItemRelationTypeController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\NpmPackageController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PackagistPackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\RepositoryTagController;
use App\Http\Controllers\RepositoryTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StackController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Livewire\Frontend\Planet;
use App\Livewire\Frontend\Planets;
use App\Livewire\Frontend\Welcome;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Welcome::class);

Route::get('/vr', Planets::class);

Route::get('/planet', Planet::class);

Route::get('/dev', TinkerController::class);

Route::get('/queue/work', QueueWorker::class);
Route::get('/schedule/run', Scheduler::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dev-index', function () {
    return view('dev-index');
});

/* Jetstream and Vemto Resources for Jetstream - ditch!

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource(
            'item-relation-types',
            ItemRelationTypeController::class
        );
        Route::resource('item-types', ItemTypeController::class);
        Route::resource('npm-packages', NpmPackageController::class);
        Route::resource('organizations', OrganizationController::class);
        Route::resource('owners', OwnerController::class);
        Route::resource(
            'packagist-packages',
            PackagistPackageController::class
        );
        Route::resource('platforms', PlatformController::class);
        Route::resource('posts', PostController::class);
        Route::resource('repository-types', RepositoryTypeController::class);
        Route::resource('tags', TagController::class);
        Route::resource('users', UserController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('items', ItemController::class);
        Route::resource('item-relations', ItemRelationController::class);
        Route::resource('stacks', StackController::class);
        Route::resource('post-types', PostTypeController::class);
        Route::resource('repositories', RepositoryController::class);
        Route::resource('repository-tags', RepositoryTagController::class);
    });
*/
