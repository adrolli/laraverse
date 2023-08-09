<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'categories' => [
        'name' => 'Categories',
        'index_title' => 'Categories List',
        'new_title' => 'New Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'show_title' => 'Show Category',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
        ],
    ],

    'platforms' => [
        'name' => 'Platforms',
        'index_title' => 'Platforms List',
        'new_title' => 'New Platform',
        'create_title' => 'Create Platform',
        'edit_title' => 'Edit Platform',
        'show_title' => 'Show Platform',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
        ],
    ],

    'stacks' => [
        'name' => 'Stacks',
        'index_title' => 'Stacks List',
        'new_title' => 'New Stack',
        'create_title' => 'Create Stack',
        'edit_title' => 'Edit Stack',
        'show_title' => 'Show Stack',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'public' => 'Public',
            'major' => 'Major',
            'user_id' => 'Created By',
        ],
    ],

    'tags' => [
        'name' => 'Tags',
        'index_title' => 'Tags List',
        'new_title' => 'New Tag',
        'create_title' => 'Create Tag',
        'edit_title' => 'Edit Tag',
        'show_title' => 'Show Tag',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
        ],
    ],

    'types' => [
        'name' => 'Types',
        'index_title' => 'Types List',
        'new_title' => 'New Type',
        'create_title' => 'Create Type',
        'edit_title' => 'Edit Type',
        'show_title' => 'Show Type',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'vendors' => [
        'name' => 'Vendors',
        'index_title' => 'Vendors List',
        'new_title' => 'New Vendor',
        'create_title' => 'Create Vendor',
        'edit_title' => 'Edit Vendor',
        'show_title' => 'Show Vendor',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'github' => 'Github',
            'packagist' => 'Packagist',
            'npm' => 'Npm',
            'website' => 'Website',
            'description' => 'Description',
        ],
    ],

    'github_organizations' => [
        'name' => 'Github Organizations',
        'index_title' => 'GithubOrganizations List',
        'new_title' => 'New Github organization',
        'create_title' => 'Create GithubOrganization',
        'edit_title' => 'Edit GithubOrganization',
        'show_title' => 'Show GithubOrganization',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'data' => 'Data',
        ],
    ],

    'github_owners' => [
        'name' => 'Github Owners',
        'index_title' => 'GithubOwners List',
        'new_title' => 'New Github owner',
        'create_title' => 'Create GithubOwner',
        'edit_title' => 'Edit GithubOwner',
        'show_title' => 'Show GithubOwner',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'data' => 'Data',
        ],
    ],

    'github_repos' => [
        'name' => 'Github Repos',
        'index_title' => 'GithubRepos List',
        'new_title' => 'New Github repo',
        'create_title' => 'Create GithubRepo',
        'edit_title' => 'Edit GithubRepo',
        'show_title' => 'Show GithubRepo',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'data' => 'Data',
            'github_organization_id' => 'Github Organization',
            'github_owner_id' => 'Github Owner',
        ],
    ],

    'github_tags' => [
        'name' => 'Github Tags',
        'index_title' => 'GithubTags List',
        'new_title' => 'New Github tag',
        'create_title' => 'Create GithubTag',
        'edit_title' => 'Edit GithubTag',
        'show_title' => 'Show GithubTag',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
        ],
    ],

    'npm_packages' => [
        'name' => 'Npm Packages',
        'index_title' => 'NpmPackages List',
        'new_title' => 'New Npm package',
        'create_title' => 'Create NpmPackage',
        'edit_title' => 'Edit NpmPackage',
        'show_title' => 'Show NpmPackage',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'data' => 'Data',
        ],
    ],

    'packagist_packages' => [
        'name' => 'Packagist Packages',
        'index_title' => 'PackagistPackages List',
        'new_title' => 'New Packagist package',
        'create_title' => 'Create PackagistPackage',
        'edit_title' => 'Edit PackagistPackage',
        'show_title' => 'Show PackagistPackage',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'data' => 'Data',
        ],
    ],

    'items' => [
        'name' => 'Items',
        'index_title' => 'Items List',
        'new_title' => 'New Item',
        'create_title' => 'Create Item',
        'edit_title' => 'Edit Item',
        'show_title' => 'Show Item',
        'inputs' => [
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'latest_version' => 'Latest Version',
            'vendor_id' => 'Vendor',
            'type_id' => 'Type',
            'website' => 'Website',
            'rating' => 'Rating',
            'health' => 'Health',
            'github_url' => 'Github Url',
            'github_stars' => 'Github Stars',
            'packagist_url' => 'Packagist Url',
            'packagist_name' => 'Packagist Name',
            'packagist_description' => 'Packagist Description',
            'packagist_downloads' => 'Packagist Downloads',
            'packagist_favers' => 'Packagist Favers',
            'npm_url' => 'Npm Url',
            'github_maintainers' => 'Github Maintainers',
            'github_repo_id' => 'Github Repo',
            'npm_package_id' => 'Npm Package',
            'packagist_package_id' => 'Packagist Package',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
