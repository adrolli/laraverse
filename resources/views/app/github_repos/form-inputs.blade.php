@php $editing = isset($githubRepo) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $githubRepo->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="slug"
            label="Slug"
            :value="old('slug', ($editing ? $githubRepo->slug : ''))"
            maxlength="255"
            placeholder="Slug"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="data" label="Data" maxlength="255" required
            >{{ old('data', ($editing ? json_encode($githubRepo->data) : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="github_organization_id"
            label="Github Organization"
            required
        >
            @php $selected = old('github_organization_id', ($editing ? $githubRepo->github_organization_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Github Organization</option>
            @foreach($githubOrganizations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="github_owner_id" label="Github Owner" required>
            @php $selected = old('github_owner_id', ($editing ? $githubRepo->github_owner_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Github Owner</option>
            @foreach($githubOwners as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
