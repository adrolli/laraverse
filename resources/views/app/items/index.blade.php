<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.items.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Item::class)
                            <a
                                href="{{ route('items.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.title')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.slug')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.description')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.latest_version')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.versions')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.vendor_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.itemType_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.website')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.popularity')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.rating')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.rating_data')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.health')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.health_data')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.github_url')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.github_stars')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.packagist_url')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.packagist_name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.packagist_description')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.packagist_downloads')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.packagist_favers')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.npm_url')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.items.inputs.github_maintainers')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.github_repo_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.npm_package_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.items.inputs.packagist_package_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $item->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->slug ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->latest_version ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($item->versions) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($item->vendor)->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($item->itemType)->title ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->website ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->popularity ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->rating ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($item->rating_data) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->health ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($item->health_data) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->github_url ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->github_stars ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->packagist_url ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->packagist_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->packagist_description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->packagist_downloads ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->packagist_favers ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $item->npm_url ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $item->github_maintainers ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($item->githubRepo)->title ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($item->npmPackage)->title ?? '-'
                                    }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($item->packagistPackage)->title
                                    ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $item)
                                        <a
                                            href="{{ route('items.edit', $item) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $item)
                                        <a
                                            href="{{ route('items.show', $item) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $item)
                                        <form
                                            action="{{ route('items.destroy', $item) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="26">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="26">
                                    <div class="mt-10 px-4">
                                        {!! $items->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
