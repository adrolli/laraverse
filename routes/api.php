<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StackController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ItemTypeController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\TagItemsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostTypeController;
use App\Http\Controllers\Api\ItemTagsController;
use App\Http\Controllers\Api\GithubTagController;
use App\Http\Controllers\Api\UserPostsController;
use App\Http\Controllers\Api\ItemPostsController;
use App\Http\Controllers\Api\ItemItemsController;
use App\Http\Controllers\Api\GithubRepoController;
use App\Http\Controllers\Api\NpmPackageController;
use App\Http\Controllers\Api\StackPostsController;
use App\Http\Controllers\Api\StackItemsController;
use App\Http\Controllers\Api\StackUsersController;
use App\Http\Controllers\Api\UserStacksController;
use App\Http\Controllers\Api\ItemStacksController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\GithubOwnerController;
use App\Http\Controllers\Api\VendorItemsController;
use App\Http\Controllers\Api\ItemTypeItemsController;
use App\Http\Controllers\Api\PlatformItemsController;
use App\Http\Controllers\Api\CategoryItemsController;
use App\Http\Controllers\Api\PostTypePostsController;
use App\Http\Controllers\Api\ItemPlatformsController;
use App\Http\Controllers\Api\ItemCategoriesController;
use App\Http\Controllers\Api\GithubRepoItemsController;
use App\Http\Controllers\Api\NpmPackageItemsController;
use App\Http\Controllers\Api\PackagistPackageController;
use App\Http\Controllers\Api\GithubOrganizationController;
use App\Http\Controllers\Api\GithubRepoGithubTagsController;
use App\Http\Controllers\Api\GithubTagGithubReposController;
use App\Http\Controllers\Api\PackagistPackageItemsController;
use App\Http\Controllers\Api\GithubOwnerGithubReposController;
use App\Http\Controllers\Api\GithubOrganizationGithubReposController;

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

        Route::apiResource(
            'github-organizations',
            GithubOrganizationController::class
        );

        // GithubOrganization Github Repos
        Route::get('/github-organizations/{githubOrganization}/github-repos', [
            GithubOrganizationGithubReposController::class,
            'index',
        ])->name('github-organizations.github-repos.index');
        Route::post('/github-organizations/{githubOrganization}/github-repos', [
            GithubOrganizationGithubReposController::class,
            'store',
        ])->name('github-organizations.github-repos.store');

        Route::apiResource('github-owners', GithubOwnerController::class);

        // GithubOwner Github Repos
        Route::get('/github-owners/{githubOwner}/github-repos', [
            GithubOwnerGithubReposController::class,
            'index',
        ])->name('github-owners.github-repos.index');
        Route::post('/github-owners/{githubOwner}/github-repos', [
            GithubOwnerGithubReposController::class,
            'store',
        ])->name('github-owners.github-repos.store');

        Route::apiResource('github-repos', GithubRepoController::class);

        // GithubRepo Items
        Route::get('/github-repos/{githubRepo}/items', [
            GithubRepoItemsController::class,
            'index',
        ])->name('github-repos.items.index');
        Route::post('/github-repos/{githubRepo}/items', [
            GithubRepoItemsController::class,
            'store',
        ])->name('github-repos.items.store');

        // GithubRepo Github Tags
        Route::get('/github-repos/{githubRepo}/github-tags', [
            GithubRepoGithubTagsController::class,
            'index',
        ])->name('github-repos.github-tags.index');
        Route::post('/github-repos/{githubRepo}/github-tags/{githubTag}', [
            GithubRepoGithubTagsController::class,
            'store',
        ])->name('github-repos.github-tags.store');
        Route::delete('/github-repos/{githubRepo}/github-tags/{githubTag}', [
            GithubRepoGithubTagsController::class,
            'destroy',
        ])->name('github-repos.github-tags.destroy');

        Route::apiResource('github-tags', GithubTagController::class);

        // GithubTag Github Repos
        Route::get('/github-tags/{githubTag}/github-repos', [
            GithubTagGithubReposController::class,
            'index',
        ])->name('github-tags.github-repos.index');
        Route::post('/github-tags/{githubTag}/github-repos/{githubRepo}', [
            GithubTagGithubReposController::class,
            'store',
        ])->name('github-tags.github-repos.store');
        Route::delete('/github-tags/{githubTag}/github-repos/{githubRepo}', [
            GithubTagGithubReposController::class,
            'destroy',
        ])->name('github-tags.github-repos.destroy');

        Route::apiResource('item-types', ItemTypeController::class);

        // ItemType Items
        Route::get('/item-types/{itemType}/items', [
            ItemTypeItemsController::class,
            'index',
        ])->name('item-types.items.index');
        Route::post('/item-types/{itemType}/items', [
            ItemTypeItemsController::class,
            'store',
        ])->name('item-types.items.store');

        Route::apiResource('npm-packages', NpmPackageController::class);

        // NpmPackage Items
        Route::get('/npm-packages/{npmPackage}/items', [
            NpmPackageItemsController::class,
            'index',
        ])->name('npm-packages.items.index');
        Route::post('/npm-packages/{npmPackage}/items', [
            NpmPackageItemsController::class,
            'store',
        ])->name('npm-packages.items.store');

        Route::apiResource(
            'packagist-packages',
            PackagistPackageController::class
        );

        // PackagistPackage Items
        Route::get('/packagist-packages/{packagistPackage}/items', [
            PackagistPackageItemsController::class,
            'index',
        ])->name('packagist-packages.items.index');
        Route::post('/packagist-packages/{packagistPackage}/items', [
            PackagistPackageItemsController::class,
            'store',
        ])->name('packagist-packages.items.store');

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

        // Stack Comments
        Route::get('/stacks/{stack}/posts', [
            StackPostsController::class,
            'index',
        ])->name('stacks.posts.index');
        Route::post('/stacks/{stack}/posts', [
            StackPostsController::class,
            'store',
        ])->name('stacks.posts.store');

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

        // Stack Users
        Route::get('/stacks/{stack}/users', [
            StackUsersController::class,
            'index',
        ])->name('stacks.users.index');
        Route::post('/stacks/{stack}/users/{user}', [
            StackUsersController::class,
            'store',
        ])->name('stacks.users.store');
        Route::delete('/stacks/{stack}/users/{user}', [
            StackUsersController::class,
            'destroy',
        ])->name('stacks.users.destroy');

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

        Route::apiResource('posts', PostController::class);

        Route::apiResource('users', UserController::class);

        // User Stacks Created
        Route::get('/users/{user}/stacks', [
            UserStacksController::class,
            'index',
        ])->name('users.stacks.index');
        Route::post('/users/{user}/stacks', [
            UserStacksController::class,
            'store',
        ])->name('users.stacks.store');

        // User Posts
        Route::get('/users/{user}/posts', [
            UserPostsController::class,
            'index',
        ])->name('users.posts.index');
        Route::post('/users/{user}/posts', [
            UserPostsController::class,
            'store',
        ])->name('users.posts.store');

        // User Stacks Used
        Route::get('/users/{user}/stacks', [
            UserStacksController::class,
            'index',
        ])->name('users.stacks.index');
        Route::post('/users/{user}/stacks/{stack}', [
            UserStacksController::class,
            'store',
        ])->name('users.stacks.store');
        Route::delete('/users/{user}/stacks/{stack}', [
            UserStacksController::class,
            'destroy',
        ])->name('users.stacks.destroy');

        Route::apiResource('post-types', PostTypeController::class);

        // PostType Comments
        Route::get('/post-types/{postType}/posts', [
            PostTypePostsController::class,
            'index',
        ])->name('post-types.posts.index');
        Route::post('/post-types/{postType}/posts', [
            PostTypePostsController::class,
            'store',
        ])->name('post-types.posts.store');

        Route::apiResource('items', ItemController::class);

        // Item Posts
        Route::get('/items/{item}/posts', [
            ItemPostsController::class,
            'index',
        ])->name('items.posts.index');
        Route::post('/items/{item}/posts', [
            ItemPostsController::class,
            'store',
        ])->name('items.posts.store');

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
    });
