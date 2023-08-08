@php $editing = isset($vendor) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $vendor->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="slug"
            label="Slug"
            :value="old('slug', ($editing ? $vendor->slug : ''))"
            maxlength="255"
            placeholder="Slug"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="github"
            label="Github"
            :value="old('github', ($editing ? $vendor->github : ''))"
            maxlength="255"
            placeholder="Github"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="packagist"
            label="Packagist"
            :value="old('packagist', ($editing ? $vendor->packagist : ''))"
            maxlength="255"
            placeholder="Packagist"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="npm"
            label="Npm"
            :value="old('npm', ($editing ? $vendor->npm : ''))"
            maxlength="255"
            placeholder="Npm"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="website"
            label="Website"
            :value="old('website', ($editing ? $vendor->website : ''))"
            maxlength="255"
            placeholder="Website"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $vendor->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
