@php $editing = isset($repository) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $repository->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="slug"
            label="Slug"
            :value="old('slug', ($editing ? $repository->slug : ''))"
            maxlength="255"
            placeholder="Slug"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $repository->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="license"
            label="License"
            :value="old('license', ($editing ? $repository->license : ''))"
            maxlength="255"
            placeholder="License"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="readme" label="Readme" maxlength="255" required
            >{{ old('readme', ($editing ? $repository->readme : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="data" label="Data" maxlength="255" required
            >{{ old('data', ($editing ? json_encode($repository->data) : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="composer"
            label="Composer"
            maxlength="255"
            required
            >{{ old('composer', ($editing ? json_encode($repository->composer) :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="npm" label="Npm" maxlength="255" required
            >{{ old('npm', ($editing ? json_encode($repository->npm) : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="code_analyzer"
            label="Code Analyzer"
            maxlength="255"
            required
            >{{ old('code_analyzer', ($editing ?
            json_encode($repository->code_analyzer) : '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="package_type"
            label="Package Type"
            :value="old('package_type', ($editing ? $repository->package_type : ''))"
            maxlength="255"
            placeholder="Package Type"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="repository_type_id"
            label="Repository Type"
            required
        >
            @php $selected = old('repository_type_id', ($editing ? $repository->repository_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Repository Type</option>
            @foreach($repositoryTypes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="organization_id" label="Organization" required>
            @php $selected = old('organization_id', ($editing ? $repository->organization_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Organization</option>
            @foreach($organizations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="owner_id" label="Owner" required>
            @php $selected = old('owner_id', ($editing ? $repository->owner_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Owner</option>
            @foreach($owners as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
