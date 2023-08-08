<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StackController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VersionController;
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
        Route::resource('items', ItemController::class);
        Route::resource('platforms', PlatformController::class);
        Route::resource('stacks', StackController::class);
        Route::resource('tags', TagController::class);
        Route::resource('types', TypeController::class);
        Route::resource('users', UserController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('versions', VersionController::class);
    });

Route::get('/github-search/{query}', 'App\Http\Controllers\ConsumeGitHubController@searchRepositories');
Route::get('/packagist-search', 'App\Http\Controllers\ConsumePackagistController@searchRepositories');
