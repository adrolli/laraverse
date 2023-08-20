<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GithubOrganizationController;
use App\Http\Controllers\GithubOwnerController;
use App\Http\Controllers\GithubRepoController;
use App\Http\Controllers\GithubTagController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\NpmPackageController;
use App\Http\Controllers\PackagistPackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StackController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
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

Route::get('/github-search/{query}', 'App\Http\Controllers\ConsumeGitHubController@searchRepositories');
Route::get('/packagist-search', 'App\Http\Controllers\ConsumePackagistController@searchRepositories');

Route::get('/', function () {
    return view('welcome');
});

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
            'github-organizations',
            GithubOrganizationController::class
        );
        Route::resource('github-owners', GithubOwnerController::class);
        Route::resource('github-repos', GithubRepoController::class);
        Route::resource('github-tags', GithubTagController::class);
        Route::resource('item-types', ItemTypeController::class);
        Route::resource('npm-packages', NpmPackageController::class);
        Route::resource(
            'packagist-packages',
            PackagistPackageController::class
        );
        Route::resource('platforms', PlatformController::class);
        Route::resource('stacks', StackController::class);
        Route::resource('tags', TagController::class);
        Route::resource('users', UserController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('items', ItemController::class);
        Route::resource('posts', PostController::class);
        Route::resource('post-types', PostTypeController::class);
    });
