@extends('admin.layouts.app')

@section('title', __('Edit Custom Field'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
    fieldType: '{{ old('type', $field->type ?? 'text') }}',
    location: '{{ old('location', $field->location ?? 'post') }}'
}">
    <form method="POST" action="{{ route('admin.custom-fields.update', $field) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Edit Custom Field') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $field->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.custom-fields.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">{{ __('Cancel') }}</a>
                <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('General Settings') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Field Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $field->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Field Key') }}</label>
                            <input type="text" name="key" value="{{ old('key', $field->key) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description / Instructions') }}</label>
                        <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">{{ old('description', $field->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Placeholder') }}</label>
                            <input type="text" name="placeholder" value="{{ old('placeholder', $field->placeholder) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Default Value') }}</label>
                            <input type="text" name="default_value" value="{{ old('default_value', $field->default_value) }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div x-show="['select', 'radio', 'checkbox'].includes(fieldType)" x-cloak class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Field Options') }}</h3>
                    <p class="text-xs text-gray-500 mb-2">{{ __('Modify the choices for this field.') }}</p>

                    <div class="space-y-2" id="options-container">
                        @php
                            $existingOptions = old('options', $field->options ?? []);
                        @endphp

                        @if(is_array($existingOptions) && count($existingOptions) > 0)
                            @foreach($existingOptions as $index => $option)
                                @php
                                    // Əgər köhnə data formatı fərqlidirsə qoruyucu yoxlama
                                    $optValue = is_array($option) ? ($option['value'] ?? '') : $option;
                                    $optLabel = is_array($option) ? ($option['label'] ?? '') : $option;
                                @endphp
                                <div class="flex gap-2">
                                    <input type="text" name="options[{{ $index }}][value]" value="{{ $optValue }}" placeholder="Value" class="flex-1 rounded-lg border-gray-300 text-sm">
                                    <input type="text" name="options[{{ $index }}][label]" value="{{ $optLabel }}" placeholder="Label" class="flex-1 rounded-lg border-gray-300 text-sm">
                                </div>
                            @endforeach
                        @else
                            <div class="flex gap-2">
                                <input type="text" name="options[0][value]" placeholder="Value" class="flex-1 rounded-lg border-gray-300 text-sm">
                                <input type="text" name="options[0][label]" placeholder="Label" class="flex-1 rounded-lg border-gray-300 text-sm">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Field Settings') }}</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Field Type') }} <span class="text-red-500">*</span></label>
                        <select name="type" x-model="fieldType" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                            <option value="text">Text Input</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="url">URL</option>
                            <option value="select">Select Dropdown</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="radio">Radio Buttons</option>
                            <option value="image">Image Upload</option>
                            <option value="file">File Upload</option>
                            <option value="color">Color Picker</option>
                            <option value="date">Date</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Location') }}</label>
                        <select name="location" x-model="location" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                            <option value="post">Posts / Pages</option>
                            <option value="taxonomy">Taxonomies</option>
                            <option value="user">Users</option>
                        </select>
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_required" value="1" {{ old('is_required', $field->is_required) ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                            <span class="text-sm text-gray-700">{{ __('Required field') }}</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_repeatable" value="1" {{ old('is_repeatable', $field->is_repeatable) ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                            <span class="text-sm text-gray-700">{{ __('Repeatable (multiple values)') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Assignments -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4" x-show="location === 'post'" x-cloak>
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Post Types') }}</h3>
                    @php $selectedPostTypes = old('post_types', $field->post_types ?? []); @endphp
                    @forelse($postTypes as $pt)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="post_types[]" value="{{ $pt->slug }}" {{ in_array($pt->slug, $selectedPostTypes) ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                            <span class="text-sm text-gray-700">{{ $pt->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-gray-500">{{ __('No post types found.') }}</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4" x-show="location === 'taxonomy'" x-cloak>
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Taxonomies') }}</h3>
                    @php $selectedTaxonomies = old('taxonomies', $field->taxonomies ?? []); @endphp
                    @forelse($taxonomies as $tax)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="taxonomies[]" value="{{ $tax->slug }}" {{ in_array($tax->slug, $selectedTaxonomies) ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                            <span class="text-sm text-gray-700">{{ $tax->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-gray-500">{{ __('No taxonomies found.') }}</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Status') }}</h3>
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        <option value="active" {{ old('status', $field->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ old('status', $field->status) === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
