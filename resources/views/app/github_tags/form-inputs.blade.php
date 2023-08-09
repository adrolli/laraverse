@php $editing = isset($githubTag) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $githubTag->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="slug"
            label="Slug"
            :value="old('slug', ($editing ? $githubTag->slug : ''))"
            maxlength="255"
            placeholder="Slug"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
