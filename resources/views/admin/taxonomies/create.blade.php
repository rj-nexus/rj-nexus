@extends('admin.layouts.app')

@section('title', __('Create Taxonomy'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <form method="POST" action="{{ route('admin.taxonomies.store') }}" class="space-y-6">
        @csrf

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Create Taxonomy') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('Define a new grouping structure (e.g., Genres, Topics).') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.taxonomies.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900">{{ __('Cancel') }}</a>
                <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
                    {{ __('Save Taxonomy') }}
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
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Genres" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Slug') }}</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generated" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm font-mono text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Singular Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="singular_name" value="{{ old('singular_name') }}" required placeholder="e.g. Genre" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Plural Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="plural_name" value="{{ old('plural_name') }}" required placeholder="e.g. Genres" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }}</label>
                        <textarea name="description" rows="3" placeholder="{{ __('Optional description for this taxonomy...') }}" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Assign to Post Types') }}</h3>
                    <p class="text-xs text-gray-500 mb-3">{{ __('Select which content types can use this taxonomy.') }}</p>

                    <div class="grid grid-cols-2 gap-3">
                        @forelse($postTypes as $pt)
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition">
                                <input type="checkbox" name="post_types[]" value="{{ $pt->slug }}" {{ in_array($pt->slug, old('post_types', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                                <span class="text-sm font-medium text-gray-700">{{ $pt->name }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 col-span-2">{{ __('No active post types found.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3">{{ __('Options') }}</h3>

                    <label class="flex items-start justify-between cursor-pointer">
                        <span>
                            <span class="block text-sm font-medium text-gray-700">{{ __('Hierarchical') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('Like categories (allows parents).') }}</span>
                        </span>
                        <input type="checkbox" name="is_hierarchical" value="1" {{ old('is_hierarchical') ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    </label>

                    <label class="flex items-start justify-between cursor-pointer">
                        <span>
                            <span class="block text-sm font-medium text-gray-700">{{ __('Public') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('Show in frontend and API.') }}</span>
                        </span>
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public', '1') ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    </label>

                    <label class="flex items-start justify-between cursor-pointer">
                        <span>
                            <span class="block text-sm font-medium text-gray-700">{{ __('Show in Menu') }}</span>
                            <span class="block text-xs text-gray-500 mt-0.5">{{ __('Display in admin sidebar.') }}</span>
                        </span>
                        <input type="checkbox" name="show_in_menu" value="1" {{ old('show_in_menu', '1') ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                    </label>

                    <div class="border-t border-gray-100 pt-4 mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
