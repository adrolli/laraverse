<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.items.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('items.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.title')
                        </h5>
                        <span>{{ $item->title ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.slug')
                        </h5>
                        <span>{{ $item->slug ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.description')
                        </h5>
                        <span>{{ $item->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.latest_version')
                        </h5>
                        <span>{{ $item->latest_version ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.vendor_id')
                        </h5>
                        <span>{{ optional($item->vendor)->title ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.type_id')
                        </h5>
                        <span>{{ optional($item->type)->title ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.website')
                        </h5>
                        <span>{{ $item->website ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.rating')
                        </h5>
                        <span>{{ $item->rating ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.health')
                        </h5>
                        <span>{{ $item->health ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.github_url')
                        </h5>
                        <span>{{ $item->github_url ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.github_stars')
                        </h5>
                        <span>{{ $item->github_stars ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.packagist_url')
                        </h5>
                        <span>{{ $item->packagist_url ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.packagist_name')
                        </h5>
                        <span>{{ $item->packagist_name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.packagist_description')
                        </h5>
                        <span>{{ $item->packagist_description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.packagist_downloads')
                        </h5>
                        <span>{{ $item->packagist_downloads ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.packagist_favers')
                        </h5>
                        <span>{{ $item->packagist_favers ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.npm_url')
                        </h5>
                        <span>{{ $item->npm_url ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.github_maintainers')
                        </h5>
                        <span>{{ $item->github_maintainers ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.github_repo_id')
                        </h5>
                        <span
                            >{{ optional($item->githubRepo)->title ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.npm_package_id')
                        </h5>
                        <span
                            >{{ optional($item->npmPackage)->title ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.items.inputs.packagist_package_id')
                        </h5>
                        <span
                            >{{ optional($item->packagistPackage)->title ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('items.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Item::class)
                    <a href="{{ route('items.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
