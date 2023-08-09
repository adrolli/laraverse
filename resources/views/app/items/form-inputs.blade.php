@php $editing = isset($item) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $item->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="slug"
            label="Slug"
            :value="old('slug', ($editing ? $item->slug : ''))"
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
            >{{ old('description', ($editing ? $item->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="latest_version"
            label="Latest Version"
            :value="old('latest_version', ($editing ? $item->latest_version : ''))"
            maxlength="255"
            placeholder="Latest Version"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="vendor_id" label="Vendor" required>
            @php $selected = old('vendor_id', ($editing ? $item->vendor_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Vendor</option>
            @foreach($vendors as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="type_id" label="Type" required>
            @php $selected = old('type_id', ($editing ? $item->type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Type</option>
            @foreach($types as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="website"
            label="Website"
            :value="old('website', ($editing ? $item->website : ''))"
            maxlength="255"
            placeholder="Website"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="rating"
            label="Rating"
            :value="old('rating', ($editing ? $item->rating : ''))"
            maxlength="255"
            placeholder="Rating"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="health"
            label="Health"
            :value="old('health', ($editing ? $item->health : ''))"
            maxlength="255"
            placeholder="Health"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="github_url"
            label="Github Url"
            :value="old('github_url', ($editing ? $item->github_url : ''))"
            maxlength="255"
            placeholder="Github Url"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="github_stars"
            label="Github Stars"
            :value="old('github_stars', ($editing ? $item->github_stars : ''))"
            max="255"
            placeholder="Github Stars"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="packagist_url"
            label="Packagist Url"
            :value="old('packagist_url', ($editing ? $item->packagist_url : ''))"
            maxlength="255"
            placeholder="Packagist Url"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="packagist_name"
            label="Packagist Name"
            :value="old('packagist_name', ($editing ? $item->packagist_name : ''))"
            maxlength="255"
            placeholder="Packagist Name"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="packagist_description"
            label="Packagist Description"
            :value="old('packagist_description', ($editing ? $item->packagist_description : ''))"
            maxlength="255"
            placeholder="Packagist Description"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="packagist_downloads"
            label="Packagist Downloads"
            :value="old('packagist_downloads', ($editing ? $item->packagist_downloads : ''))"
            max="255"
            placeholder="Packagist Downloads"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="packagist_favers"
            label="Packagist Favers"
            :value="old('packagist_favers', ($editing ? $item->packagist_favers : ''))"
            max="255"
            placeholder="Packagist Favers"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="npm_url"
            label="Npm Url"
            :value="old('npm_url', ($editing ? $item->npm_url : ''))"
            maxlength="255"
            placeholder="Npm Url"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="github_maintainers"
            label="Github Maintainers"
            :value="old('github_maintainers', ($editing ? $item->github_maintainers : ''))"
            max="255"
            placeholder="Github Maintainers"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="github_repo_id" label="Github Repo">
            @php $selected = old('github_repo_id', ($editing ? $item->github_repo_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Github Repo</option>
            @foreach($githubRepos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="npm_package_id" label="Npm Package">
            @php $selected = old('npm_package_id', ($editing ? $item->npm_package_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Npm Package</option>
            @foreach($npmPackages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="packagist_package_id" label="Packagist Package">
            @php $selected = old('packagist_package_id', ($editing ? $item->packagist_package_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Packagist Package</option>
            @foreach($packagistPackages as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
