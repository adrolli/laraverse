<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @lang('crud.repositories.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('repositories.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="px-4 mt-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.title')
                        </h5>
                        <span>{{ $repository->title ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.slug')
                        </h5>
                        <span>{{ $repository->slug ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.description')
                        </h5>
                        <span>{{ $repository->description ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.license')
                        </h5>
                        <span>{{ $repository->license ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.readme')
                        </h5>
                        <span>{{ $repository->readme ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.data')
                        </h5>
                        <pre>{{ json_encode($repository->data) ?? '-' }}</pre>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.composer')
                        </h5>
                        <pre>
{{ json_encode($repository->composer) ?? '-' }}</pre
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.npm')
                        </h5>
                        <pre>{{ json_encode($repository->npm) ?? '-' }}</pre>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.code_analyzer')
                        </h5>
                        <pre>
{{ json_encode($repository->code_analyzer) ?? '-' }}</pre
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.repository_type_id')
                        </h5>
                        <span
                            >{{ optional($repository->repositoryType)->title ??
                            '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.organization_id')
                        </h5>
                        <span
                            >{{ optional($repository->organization)->title ??
                            '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.repositories.inputs.owner_id')
                        </h5>
                        <span
                            >{{ optional($repository->owner)->title ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('repositories.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Repository::class)
                    <a href="{{ route('repositories.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
