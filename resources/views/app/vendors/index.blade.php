<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.vendors.index_title')
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
                            @can('create', App\Models\Vendor::class)
                            <a
                                href="{{ route('vendors.create') }}"
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
                                    @lang('crud.vendors.inputs.title')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.slug')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.avatar')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.description')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.email')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.website')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.github')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.packagist')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.npm')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.owner_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.vendors.inputs.organization_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($vendors as $vendor)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->slug ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $vendor->avatar ? \Storage::url($vendor->avatar) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->email ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->website ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->github ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->packagist ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $vendor->npm ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($vendor->owner)->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($vendor->organization)->title ??
                                    '-' }}
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
                                        @can('update', $vendor)
                                        <a
                                            href="{{ route('vendors.edit', $vendor) }}"
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
                                        @endcan @can('view', $vendor)
                                        <a
                                            href="{{ route('vendors.show', $vendor) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $vendor)
                                        <form
                                            action="{{ route('vendors.destroy', $vendor) }}"
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
                                <td colspan="12">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="mt-10 px-4">
                                        {!! $vendors->render() !!}
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
