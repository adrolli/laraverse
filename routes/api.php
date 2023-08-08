<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StackController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemTagsController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\TagItemsController;
use App\Http\Controllers\Api\ItemItemsController;
use App\Http\Controllers\Api\TypeItemsController;
use App\Http\Controllers\Api\ItemStacksController;
use App\Http\Controllers\Api\StackItemsController;
use App\Http\Controllers\Api\UserStacksController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\VendorItemsController;
use App\Http\Controllers\Api\ItemVersionsController;
use App\Http\Controllers\Api\CategoryItemsController;
use App\Http\Controllers\Api\ItemPlatformsController;
use App\Http\Controllers\Api\PlatformItemsController;
use App\Http\Controllers\Api\ItemCategoriesController;
use App\Http\Controllers\Api\VersionVersionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('categories', CategoryController::class);

        // Category Items
        Route::get('/categories/{category}/items', [
            CategoryItemsController::class,
            'index',
        ])->name('categories.items.index');
        Route::post('/categories/{category}/items/{item}', [
            CategoryItemsController::class,
            'store',
        ])->name('categories.items.store');
        Route::delete('/categories/{category}/items/{item}', [
            CategoryItemsController::class,
            'destroy',
        ])->name('categories.items.destroy');

        Route::apiResource('items', ItemController::class);

        // Item Versions
        Route::get('/items/{item}/versions', [
            ItemVersionsController::class,
            'index',
        ])->name('items.versions.index');
        Route::post('/items/{item}/versions', [
            ItemVersionsController::class,
            'store',
        ])->name('items.versions.store');

        // Item Platforms
        Route::get('/items/{item}/platforms', [
            ItemPlatformsController::class,
            'index',
        ])->name('items.platforms.index');
        Route::post('/items/{item}/platforms/{platform}', [
            ItemPlatformsController::class,
            'store',
        ])->name('items.platforms.store');
        Route::delete('/items/{item}/platforms/{platform}', [
            ItemPlatformsController::class,
            'destroy',
        ])->name('items.platforms.destroy');

        // Item Tags
        Route::get('/items/{item}/tags', [
            ItemTagsController::class,
            'index',
        ])->name('items.tags.index');
        Route::post('/items/{item}/tags/{tag}', [
            ItemTagsController::class,
            'store',
        ])->name('items.tags.store');
        Route::delete('/items/{item}/tags/{tag}', [
            ItemTagsController::class,
            'destroy',
        ])->name('items.tags.destroy');

        // Item Categories
        Route::get('/items/{item}/categories', [
            ItemCategoriesController::class,
            'index',
        ])->name('items.categories.index');
        Route::post('/items/{item}/categories/{category}', [
            ItemCategoriesController::class,
            'store',
        ])->name('items.categories.store');
        Route::delete('/items/{item}/categories/{category}', [
            ItemCategoriesController::class,
            'destroy',
        ])->name('items.categories.destroy');

        // Item Stacks
        Route::get('/items/{item}/stacks', [
            ItemStacksController::class,
            'index',
        ])->name('items.stacks.index');
        Route::post('/items/{item}/stacks/{stack}', [
            ItemStacksController::class,
            'store',
        ])->name('items.stacks.store');
        Route::delete('/items/{item}/stacks/{stack}', [
            ItemStacksController::class,
            'destroy',
        ])->name('items.stacks.destroy');

        // Item Dependencies
        Route::get('/items/{item}/items', [
            ItemItemsController::class,
            'index',
        ])->name('items.items.index');
        Route::post('/items/{item}/items/{item}', [
            ItemItemsController::class,
            'store',
        ])->name('items.items.store');
        Route::delete('/items/{item}/items/{item}', [
            ItemItemsController::class,
            'destroy',
        ])->name('items.items.destroy');

        // Item Items
        Route::get('/items/{item}/items', [
            ItemItemsController::class,
            'index',
        ])->name('items.items.index');
        Route::post('/items/{item}/items/{item}', [
            ItemItemsController::class,
            'store',
        ])->name('items.items.store');
        Route::delete('/items/{item}/items/{item}', [
            ItemItemsController::class,
            'destroy',
        ])->name('items.items.destroy');

        Route::apiResource('platforms', PlatformController::class);

        // Platform Items
        Route::get('/platforms/{platform}/items', [
            PlatformItemsController::class,
            'index',
        ])->name('platforms.items.index');
        Route::post('/platforms/{platform}/items/{item}', [
            PlatformItemsController::class,
            'store',
        ])->name('platforms.items.store');
        Route::delete('/platforms/{platform}/items/{item}', [
            PlatformItemsController::class,
            'destroy',
        ])->name('platforms.items.destroy');

        Route::apiResource('stacks', StackController::class);

        // Stack Items
        Route::get('/stacks/{stack}/items', [
            StackItemsController::class,
            'index',
        ])->name('stacks.items.index');
        Route::post('/stacks/{stack}/items/{item}', [
            StackItemsController::class,
            'store',
        ])->name('stacks.items.store');
        Route::delete('/stacks/{stack}/items/{item}', [
            StackItemsController::class,
            'destroy',
        ])->name('stacks.items.destroy');

        Route::apiResource('tags', TagController::class);

        // Tag Items
        Route::get('/tags/{tag}/items', [
            TagItemsController::class,
            'index',
        ])->name('tags.items.index');
        Route::post('/tags/{tag}/items/{item}', [
            TagItemsController::class,
            'store',
        ])->name('tags.items.store');
        Route::delete('/tags/{tag}/items/{item}', [
            TagItemsController::class,
            'destroy',
        ])->name('tags.items.destroy');

        Route::apiResource('types', TypeController::class);

        // Type Items
        Route::get('/types/{type}/items', [
            TypeItemsController::class,
            'index',
        ])->name('types.items.index');
        Route::post('/types/{type}/items', [
            TypeItemsController::class,
            'store',
        ])->name('types.items.store');

        Route::apiResource('users', UserController::class);

        // User Stacks
        Route::get('/users/{user}/stacks', [
            UserStacksController::class,
            'index',
        ])->name('users.stacks.index');
        Route::post('/users/{user}/stacks', [
            UserStacksController::class,
            'store',
        ])->name('users.stacks.store');

        Route::apiResource('vendors', VendorController::class);

        // Vendor Items
        Route::get('/vendors/{vendor}/items', [
            VendorItemsController::class,
            'index',
        ])->name('vendors.items.index');
        Route::post('/vendors/{vendor}/items', [
            VendorItemsController::class,
            'store',
        ])->name('vendors.items.store');

        Route::apiResource('versions', VersionController::class);

        // Version Dependencies
        Route::get('/versions/{version}/versions', [
            VersionVersionsController::class,
            'index',
        ])->name('versions.versions.index');
        Route::post('/versions/{version}/versions/{version}', [
            VersionVersionsController::class,
            'store',
        ])->name('versions.versions.store');
        Route::delete('/versions/{version}/versions/{version}', [
            VersionVersionsController::class,
            'destroy',
        ])->name('versions.versions.destroy');

        // Version Versions
        Route::get('/versions/{version}/versions', [
            VersionVersionsController::class,
            'index',
        ])->name('versions.versions.index');
        Route::post('/versions/{version}/versions/{version}', [
            VersionVersionsController::class,
            'store',
        ])->name('versions.versions.store');
        Route::delete('/versions/{version}/versions/{version}', [
            VersionVersionsController::class,
            'destroy',
        ])->name('versions.versions.destroy');
    });
