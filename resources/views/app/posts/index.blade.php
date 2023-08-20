<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.posts.index_title')
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
                            @can('create', App\Models\Post::class)
                            <a
                                href="{{ route('posts.create') }}"
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
                                    @lang('crud.posts.inputs.title')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.slug')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.content')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.data')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.user_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.item_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.stack_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.posts.inputs.post_type_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($posts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $post->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $post->slug ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $post->content ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <pre>
{{ json_encode($post->data) ?? '-' }}</pre
                                    >
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($post->user)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($post->item)->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($post->stack)->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($post->postType)->title ?? '-'
                                    }}
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
                                        @can('update', $post)
                                        <a
                                            href="{{ route('posts.edit', $post) }}"
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
                                        @endcan @can('view', $post)
                                        <a
                                            href="{{ route('posts.show', $post) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $post)
                                        <form
                                            action="{{ route('posts.destroy', $post) }}"
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
                                <td colspan="9">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9">
                                    <div class="mt-10 px-4">
                                        {!! $posts->render() !!}
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
