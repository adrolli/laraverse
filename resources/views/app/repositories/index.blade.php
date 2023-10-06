<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.repositories.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mt-4 mb-5">
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
                        <div class="text-right md:w-1/2">
                            @can('create', App\Models\Repository::class)
                            <a
                                href="{{ route('repositories.create') }}"
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
                                    @lang('crud.repositories.inputs.title')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.slug')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.description')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.license')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.readme')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.data')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.composer')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.npm')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.code_analyzer')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.repository_type_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.organization_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.repositories.inputs.owner_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($repositories as $repository)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $repository->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $repository->slug ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $repository->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $repository->license ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $repository->readme ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($repository->data) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($repository->composer) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($repository->npm) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($repository->code_analyzer) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($repository->repositoryType)->title
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($repository->organization)->title
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($repository->owner)->title ??
                                    '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="relative inline-flex align-middle "
                                    >
                                        @can('update', $repository)
                                        <a
                                            href="{{ route('repositories.edit', $repository) }}"
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
                                        @endcan @can('view', $repository)
                                        <a
                                            href="{{ route('repositories.show', $repository) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $repository)
                                        <form
                                            action="{{ route('repositories.destroy', $repository) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="text-red-600 icon ion-md-trash"
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14">
                                    <div class="px-4 mt-10">
                                        {!! $repositories->render() !!}
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
