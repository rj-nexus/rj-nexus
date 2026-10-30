@extends('admin.layouts.app')

@section('title', __('Create Post Type'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <form method="POST" action="{{ route('admin.post-types.store') }}" class="space-y-6">
        @csrf

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Create Post Type') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('Define a new content structure for your site.') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.post-types.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">{{ __('Cancel') }}</a>
                <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
                    {{ __('Save Post Type') }}
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Portfolio" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Slug') }}</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generated" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Singular Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="singular_name" value="{{ old('singular_name') }}" required placeholder="e.g. Project" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Plural Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="plural_name" value="{{ old('plural_name') }}" required placeholder="e.g. Projects" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Supports') }}</h3>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="supports_builder" value="1" {{ old('supports_builder', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        <span class="text-sm text-gray-700">{{ __('RJBuilder Support') }}</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="supports_thumbnail" value="1" {{ old('supports_thumbnail', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        <span class="text-sm text-gray-700">{{ __('Featured Image') }}</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="supports_comments" value="1" {{ old('supports_comments', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        <span class="text-sm text-gray-700">{{ __('Comments') }}</span>
                    </label>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Visibility & Hierarchy') }}</h3>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-sm text-gray-700">{{ __('Public') }}</span>
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-sm text-gray-700">{{ __('Has Archive') }}</span>
                        <input type="checkbox" name="has_archive" value="1" {{ old('has_archive', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-sm text-gray-700">{{ __('Hierarchical (like pages)') }}</span>
                        <input type="checkbox" name="is_hierarchical" value="1" {{ old('is_hierarchical') ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    </label>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Menu Options') }}</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Menu Icon') }}</label>
                        <select name="icon" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                            <option value="file">{{ __('File') }}</option>
                            <option value="folder">{{ __('Folder') }}</option>
                            <option value="image">{{ __('Image') }}</option>
                            <option value="briefcase">{{ __('Briefcase') }}</option>
                            <option value="shopping-bag">{{ __('Shopping Bag') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Menu Position') }}</label>
                        <input type="number" name="menu_position" value="{{ old('menu_position', '25') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        <p class="text-xs text-gray-500 mt-1">{{ __('Lower numbers appear higher up.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
