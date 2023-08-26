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
        <div
            x-data="imageViewer('{{ $editing && $vendor->avatar ? \Storage::url($vendor->avatar) : '' }}')"
        >
            <x-inputs.partials.label
                name="avatar"
                label="Avatar"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="avatar"
                    id="avatar"
                    @change="fileChosen"
                />
            </div>

            @error('avatar') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $vendor->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $vendor->email : ''))"
            maxlength="255"
            placeholder="Email"
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="website"
            label="Website"
            :value="old('website', ($editing ? $vendor->website : ''))"
            maxlength="255"
            placeholder="Website"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="github"
            label="Github"
            :value="old('github', ($editing ? $vendor->github : ''))"
            maxlength="255"
            placeholder="Github"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="packagist"
            label="Packagist"
            :value="old('packagist', ($editing ? $vendor->packagist : ''))"
            maxlength="255"
            placeholder="Packagist"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="npm"
            label="Npm"
            :value="old('npm', ($editing ? $vendor->npm : ''))"
            maxlength="255"
            placeholder="Npm"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="owner_id" label="Owner">
            @php $selected = old('owner_id', ($editing ? $vendor->owner_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Owner</option>
            @foreach($owners as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="organization_id" label="Organization">
            @php $selected = old('organization_id', ($editing ? $vendor->organization_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Organization</option>
            @foreach($organizations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
