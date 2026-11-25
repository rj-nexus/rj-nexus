@extends('admin.layouts.app')

@section('title', $type === 'page' ? __('Pages') : __('Posts'))

@section('content')
<div class="space-y-6" x-data="{
    selected: [],
    bulkAction: '',
    quickEditId: null,
    quickSaving: false,

    async quickSave(formEl) {
        if (this.quickSaving) return;
        this.quickSaving = true;
        try {
            const res = await fetch(formEl.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(formEl)
            });
            const data = await res.json();
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || '{{ __('Failed to save.') }}');
            }
        } catch (e) {
            alert('{{ __('Network error.') }}');
        } finally {
            this.quickSaving = false;
        }
    }
}">

    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-base font-semibold text-gray-900">{{ $type === 'page' ? __('Pages') : __('Posts') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage your content, drafts, and scheduled items.') }}</p>
        </div>

        <div class="flex items-center gap-3">
            @if ($type === 'post')
                <a href="{{ route('admin.tools.marketing') }}"
                   class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-900/40 backdrop-blur-md border border-white/10 hover:border-rj-purple/50 text-sm font-bold text-white transition-all duration-300 hover:bg-gray-900/60 hover:shadow-[0_0_20px_rgba(167,139,250,0.3)] overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    
                    <svg class="w-4 h-4 text-rj-pink group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span class="relative z-10">{{ __('Create Marketing Post') }}</span>
                </a>
            @endif

            <a href="{{ route('admin.posts.create', ['type' => $type]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add New') }}
            </a>
        </div>
    </div>

    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-base font-semibold text-gray-900">{{ $type === 'page' ? __('Pages') : __('Posts') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage your content, drafts, and scheduled items.') }}</p>
        </div>

        <div class="flex items-center gap-3">
            @if ($type !== 'page')
                <a href="{{ route('admin.tools.marketing') }}"
                   class="group relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rj-purple/10 backdrop-blur-md border border-rj-purple/30 text-sm font-bold text-rj-purple transition-all duration-300 hover:bg-gradient-to-r hover:from-rj-purple hover:to-rj-pink hover:text-white hover:border-transparent hover:shadow-lg hover:shadow-rj-purple/40 overflow-hidden">
                    
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/50 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                    
                    <svg class="w-4 h-4 text-rj-pink group-hover:text-white group-hover:scale-110 group-hover:rotate-12 transition-all duration-300 relative z-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <span class="relative z-10">{{ __('Create Marketing Post') }}</span>
                </a>
            @endif

            <a href="{{ route('admin.posts.create', ['type' => $type]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ __('Add New') }}
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between gap-3 flex-wrap">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="flex items-center gap-3 flex-1 min-w-[200px] flex-wrap">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="status" value="{{ $status }}">

                <div class="relative flex-1 min-w-[200px] max-w-md">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="{{ __('Search posts...') }}"
                           class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                </div>

                <select name="category" class="rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="tag" class="rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-sm">
                    <option value="">{{ __('All Tags') }}</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium text-gray-700 transition">
                    {{ __('Filter') }}
                </button>

                @if (request()->hasAny(['q', 'category', 'tag']))
                    <a href="{{ route('admin.posts.index', ['type' => $type, 'status' => $status]) }}"
                       class="text-sm text-gray-500 hover:text-gray-900">{{ __('Clear') }}</a>
                @endif
            </form>

            @if ($posts->total() > 0)
                <div class="text-xs text-gray-500">{{ $posts->total() }} {{ __('item(s)') }}</div>
            @endif
        </div>

        @if ($posts->isEmpty())
            <div class="p-16 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4v6h6M8 13h8M8 17h5"/></svg>
                <p class="mt-4 text-sm text-gray-500">
                    @if (request('q') || request('category') || request('tag'))
                        {{ __('No posts match your filters.') }}
                    @elseif ($status === 'trash')
                        {{ __('Trash is empty.') }}
                    @else
                        {{ __('No posts yet. Create your first one.') }}
                    @endif
                </p>
                <a href="{{ route('admin.posts.create', ['type' => $type]) }}"
                   class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    {{ __('Create First Post') }}
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('admin.posts.bulk') }}" @submit.prevent="if (selected.length === 0 || !bulkAction) return; $el.submit()">
                @csrf

                <div x-show="selected.length > 0" x-cloak class="px-4 py-2.5 border-b border-gray-100 bg-rj-purple/5 flex items-center gap-3 flex-wrap">
                    <span class="text-xs text-gray-600"><b x-text="selected.length"></b> {{ __('selected') }}</span>

                    <select x-model="bulkAction" class="rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple text-xs">
                        <option value="">{{ __('Bulk Actions') }}</option>
                        <option value="publish">{{ __('Publish') }}</option>
                        <option value="draft">{{ __('Move to Draft') }}</option>
                        <option value="sticky">{{ __('Mark Sticky') }}</option>
                        <option value="unsticky">{{ __('Unmark Sticky') }}</option>
                        <option value="trash">{{ __('Move to Trash') }}</option>
                        <option value="delete">{{ __('Delete Permanently') }}</option>
                    </select>

                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-xs font-medium hover:bg-gray-800 transition">
                        {{ __('Apply') }}
                    </button>

                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <input type="hidden" name="action" :value="bulkAction">
                </div>

                <table class="w-full text-sm table-fixed" style="table-layout:fixed;width:100%;">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="w-10 px-4 py-3">
                                <input type="checkbox"
                                       @change="selected = $event.target.checked ? [{{ $posts->pluck('id')->implode(',') }}] : []"
                                       :checked="selected.length === {{ $posts->count() }} && {{ $posts->count() }} > 0"
                                       class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                            </th>
                            <th class="text-left font-medium text-gray-600 px-4 py-3" style="width:auto;">{{ __('Title') }}</th>
                            <th class="w-40 text-left font-medium text-gray-600 px-4 py-3 hidden lg:table-cell">{{ __('Author') }}</th>
                            <th class="w-48 text-left font-medium text-gray-600 px-4 py-3 hidden xl:table-cell">{{ __('Categories / Tags') }}</th>
                            <th class="w-24 text-center font-medium text-gray-600 px-4 py-3 hidden md:table-cell">{{ __('Comments') }}</th>
                            <th class="w-32 text-left font-medium text-gray-600 px-4 py-3 hidden md:table-cell">{{ __('Date') }}</th>
                            <th class="w-48 text-right font-medium text-gray-600 px-4 py-3">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($posts as $post)
                            <tr class="hover:bg-gray-50/50 transition" :class="quickEditId === {{ $post->id }} ? 'bg-blue-50/40' : ''">
                                <td class="px-4 py-3">
                                    <input type="checkbox" :value="{{ $post->id }}" x-model.number="selected"
                                           class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                                </td>

                                <td class="px-4 py-3" style="max-width:0;overflow:hidden;">
                                    <div class="flex items-start gap-3" style="min-width:0;">
                                        @if ($post->featured_image)
                                            <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : asset($post->featured_image) }}"
                                                 alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0 border border-gray-200">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-rj-purple/15 to-rj-pink/15 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-rj-purple/60" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 4v6h6"/></svg>
                                            </div>
                                        @endif

                                        <div class="flex-1" style="min-width:0;overflow:hidden;">
                                            <div class="flex items-center gap-2" style="min-width:0;">
                                                @if ($post->is_sticky)
                                                    <span title="{{ __('Sticky') }}" class="text-amber-500 flex-shrink-0">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                    </span>
                                                @endif

                                                <a href="{{ route('admin.posts.edit', $post) }}"
                                                   class="block flex-1 text-sm font-medium text-gray-900 hover:text-rj-purple" style="min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                                                   title="{{ $post->title ?: __('(no title)') }}">
                                                    {{ $post->title ?: __('(no title)') }}
                                                </a>

                                                @if ($post->status === 'draft')
                                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium bg-amber-50 text-amber-700 flex-shrink-0">{{ __('Draft') }}</span>
                                                @elseif ($post->status === 'scheduled')
                                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 flex-shrink-0">{{ __('Scheduled') }}</span>
                                                @elseif ($post->status === 'trash')
                                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 flex-shrink-0">{{ __('Trash') }}</span>
                                                @endif
                                            </div>

                                            <div class="text-xs text-gray-500 mt-0.5" style="min-width:0;overflow:hidden;" title="/{{ $post->slug }}">
                                                <code class="font-mono" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">/{{ $post->slug }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 hidden lg:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-rj-purple to-rj-pink flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                            {{ strtoupper(substr($post->author->name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-gray-700 truncate">{{ $post->author->name ?? '—' }}</span>
                                    </div>
                                </td>

                                <td class="px-4 py-3 hidden xl:table-cell">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($post->categories->take(2) as $cat)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-rj-purple/10 text-rj-purple text-xs font-medium truncate max-w-[80px]">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach

                                        @if ($post->categories->count() > 2)
                                            <span class="text-xs text-gray-400">+{{ $post->categories->count() - 2 }}</span>
                                        @endif

                                        @if ($post->categories->isEmpty() && $post->tags->isEmpty())
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3 hidden md:table-cell text-center">
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        {{ $post->comments_count ?? 0 }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 hidden md:table-cell">
                                    <div class="text-xs text-gray-600 whitespace-nowrap">
                                        @if ($post->status === 'scheduled' && $post->published_at)
                                            <div class="text-blue-600 font-medium">{{ __('Scheduled') }}</div>
                                            <div>{{ $post->published_at->format('M d, Y H:i') }}</div>
                                        @elseif ($post->published_at)
                                            <div>{{ $post->published_at->format('M d, Y') }}</div>
                                            <div class="text-gray-400">{{ $post->published_at->format('H:i') }}</div>
                                        @else
                                            <div>{{ $post->created_at->format('M d, Y') }}</div>
                                            <div class="text-gray-400">{{ __('Last modified') }}</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        @if ($post->status === 'trash')
                                            <form method="POST" action="{{ route('admin.posts.restore', $post) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-green-50 hover:text-green-600 transition" title="{{ __('Restore') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                                  onsubmit="return confirm('{{ __('Permanently delete this post?') }}')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition" title="{{ __('Delete Permanently') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button"
                                                    @click="quickEditId = (quickEditId === {{ $post->id }} ? null : {{ $post->id }})"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition"
                                                    :class="quickEditId === {{ $post->id }} ? 'bg-blue-100 text-blue-600' : ''"
                                                    title="{{ __('Quick Edit') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            </button>

                                            <a href="{{ route('admin.posts.edit', $post) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-rj-purple/10 hover:text-rj-purple transition" title="{{ __('Edit') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </a>

                                            <a href="{{ route('admin.posts.show', $post) }}"
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition" title="{{ __('View') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.46 12C3.73 7.94 7.52 5 12 5s8.27 2.94 9.54 7c-1.27 4.06-5.06 7-9.54 7S3.73 16.06 2.46 12z"/></svg>
                                            </a>

                                            <form method="POST" action="{{ route('admin.posts.duplicate', $post) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition" title="{{ __('Duplicate') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.posts.trash-action', $post) }}"
                                                  onsubmit="return confirm('{{ __('Move this post to trash?') }}')" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600 transition" title="{{ __('Move to Trash') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($post->status !== 'trash')
                                <tr x-show="quickEditId === {{ $post->id }}" x-cloak>
                                    <td colspan="7" class="px-4 py-5 bg-gradient-to-b from-blue-50/60 to-white border-b border-blue-100">
                                        <form method="POST" action="{{ route('admin.posts.quick-edit', $post) }}"
                                              x-data="{ lang: '{{ $baseLocale }}' }"
                                              @submit.prevent="quickSave($el)">
                                            @csrf

                                            <div class="flex items-center gap-2 mb-4">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                <h4 class="text-sm font-bold text-gray-900">{{ __('Quick Edit') }}</h4>
                                                <span class="text-xs text-gray-500 truncate min-w-0">— {{ $post->title ?: __('(no title)') }}</span>
                                            </div>

                                            <div class="flex flex-wrap gap-1.5 mb-3">
                                                @foreach ($locales as $locale)
                                                    <button type="button"
                                                            @click="lang = '{{ $locale }}'"
                                                            :class="lang === '{{ $locale }}' ? 'bg-rj-purple text-white border-rj-purple' : 'bg-white text-gray-600 border-gray-200 hover:border-rj-purple/50'"
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[11px] font-bold uppercase tracking-wide transition">
                                                        @if (file_exists(public_path("images/flags/{$locale}.svg")))
                                                            <img src="{{ asset("images/flags/{$locale}.svg") }}" alt="" class="w-3.5 h-2.5 object-cover rounded-sm">
                                                        @endif
                                                        {{ strtoupper($locale) }}
                                                        @if ($locale === $baseLocale)
                                                            <span class="w-1 h-1 rounded-full bg-rj-pink"></span>
                                                        @endif
                                                    </button>
                                                @endforeach
                                            </div>

                                            <div class="mb-4">
                                                @foreach ($locales as $locale)
                                                    @php
                                                        $t = $post->translations->firstWhere('locale', $locale);
                                                        $isBase = $locale === $baseLocale;
                                                    @endphp
                                                    <div x-show="lang === '{{ $locale }}'" @if (! $isBase) x-cloak @endif
                                                         class="grid grid-cols-1 md:grid-cols-2 gap-3 max-w-3xl">
                                                        <div class="min-w-0">
                                                            <label class="block text-[11px] font-medium text-gray-500 mb-1">{{ __('Title') }}</label>
                                                            <input type="text"
                                                                   name="{{ $isBase ? 'title' : "translations[{$locale}][title]" }}"
                                                                   value="{{ $isBase ? $post->title : ($t?->title) }}"
                                                                   placeholder="{{ __('Title') }}"
                                                                   class="w-full text-sm rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                                                        </div>

                                                        <div class="min-w-0">
                                                            <label class="block text-[11px] font-medium text-gray-500 mb-1">{{ __('Slug') }}</label>
                                                            <input type="text"
                                                                   name="{{ $isBase ? 'slug' : "translations[{$locale}][slug]" }}"
                                                                   value="{{ $isBase ? $post->slug : ($t?->slug) }}"
                                                                   placeholder="{{ __('Slug') }}"
                                                                   class="w-full text-sm font-mono rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="flex items-center justify-between gap-3 flex-wrap">
                                                <div class="flex items-center gap-2">
                                                    <label class="text-xs font-medium text-gray-700">{{ __('Status') }}:</label>
                                                    <select name="status" class="text-sm rounded-lg border-gray-300 focus:border-rj-purple focus:ring-rj-purple">
                                                        <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                                        <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                                                        <option value="scheduled" {{ $post->status === 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                                                    </select>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                            @click="quickEditId = null"
                                                            class="px-4 py-1.5 rounded-lg bg-white border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                                                        {{ __('Cancel') }}
                                                    </button>
                                                    <button type="submit"
                                                            :disabled="quickSaving"
                                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-medium hover:opacity-90 transition disabled:opacity-60">
                                                        <svg x-show="!quickSaving" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                        <svg x-show="quickSaving" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"/></svg>
                                                        <span x-text="quickSaving ? '{{ __('Saving...') }}' : '{{ __('Update') }}'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </form>

            @if ($posts->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif

    </div>

</div>
@endsection