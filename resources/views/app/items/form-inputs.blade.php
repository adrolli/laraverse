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
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="versions" label="Versions" maxlength="255"
            >{{ old('versions', ($editing ? json_encode($item->versions) : ''))
            }}</x-inputs.textarea
        >
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
        <x-inputs.select name="itemType_id" label="Item Type" required>
            @php $selected = old('itemType_id', ($editing ? $item->itemType_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Item Type</option>
            @foreach($itemTypes as $value => $label)
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
        <x-inputs.number
            name="popularity"
            label="Popularity"
            :value="old('popularity', ($editing ? $item->popularity : ''))"
            max="255"
            placeholder="Popularity"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="rating"
            label="Rating"
            :value="old('rating', ($editing ? $item->rating : ''))"
            max="255"
            placeholder="Rating"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="rating_data"
            label="Rating Data"
            maxlength="255"
            >{{ old('rating_data', ($editing ? json_encode($item->rating_data) :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="health"
            label="Health"
            :value="old('health', ($editing ? $item->health : ''))"
            max="255"
            placeholder="Health"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="health_data"
            label="Health Data"
            maxlength="255"
            >{{ old('health_data', ($editing ? json_encode($item->health_data) :
            '')) }}</x-inputs.textarea
        >
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
