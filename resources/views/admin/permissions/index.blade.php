@extends('admin.layouts.app')

@section('title', __('Permissions'))

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{
    createOpen: false,
    editOpen: false,
    rolesOpen: false,
    currentPermission: {},
    availableRoles: [],

    async openRoles(permission) {
        this.currentPermission = permission;
        this.rolesOpen = true;
        this.availableRoles = [];

        try {
            const res = await fetch(`/admin/permissions/${permission.id}/roles`);
            const data = await res.json();
            this.availableRoles = data.roles || [];
        } catch (e) {
            console.error('Failed to load roles');
        }
    },

    async syncRoles() {
        if (!this.currentPermission.id) return;

        const selectedRoleIds = this.availableRoles.filter(r => r.assigned).map(r => r.id);

        try {
            await fetch(`/admin/permissions/${this.currentPermission.id}/sync-roles`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ role_ids: selectedRoleIds })
            });
            this.rolesOpen = false;
            window.location.reload();
        } catch (e) {
            alert('{{ __('Failed to sync roles') }}');
        }
    }
}">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('Permissions') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage granular access controls for your roles.') }}</p>
        </div>
        <button type="button" @click="createOpen = true" class="inline-flex items-center gap-2 px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            {{ __('Add Permission') }}
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">{{ session('error') }}</div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Total Permissions') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['all']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Permission Groups') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($counts['groups']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ __('Total Roles') }}</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($roleCount) }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.permissions.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-500 mb-1">{{ __('Search') }}</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('Search by name or slug...') }}" class="w-full rounded-lg border-gray-300 text-sm focus:ring-rj-purple focus:border-rj-purple">
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">{{ __('Search') }}</button>
            @if(request()->anyFilled(['q']))
                <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <!-- Grouped Permissions -->
    <div class="space-y-6">
        @forelse($grouped as $groupName => $permissions)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-3 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">
                        {{ $groupLabels[$groupName] ?? ucfirst($groupName) }}
                    </h3>
                    <span class="px-2 py-0.5 rounded-full bg-gray-200 text-gray-600 text-xs font-bold">{{ $permissions->count() }}</span>
                </div>
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-gray-100">
                        @foreach($permissions as $permission)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 w-1/3">
                                    <div class="font-bold text-gray-900">{{ $permission->name }}</div>
                                    @if($permission->description)
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $permission->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-xs font-mono bg-gray-100 px-2 py-1 rounded text-gray-600">{{ $permission->slug }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $permission->roles_count ?? 0 }} {{ __('roles') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click="openRoles({{ $permission }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="{{ __('Assign Roles') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        </button>

                                        <button type="button" @click="currentPermission = {{ $permission }}; editOpen = true" class="p-2 text-gray-400 hover:text-rj-purple hover:bg-rj-purple/10 rounded-lg transition" title="{{ __('Edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>

                                        <form method="POST" action="{{ route('admin.permissions.destroy', $permission) }}" onsubmit="return confirm('{{ __('Delete this permission?') }}')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="{{ __('Delete') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <p>{{ __('No permissions found.') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Create Modal -->
    <div x-show="createOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="createOpen" x-transition.opacity @click="createOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="createOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Add New Permission') }}</h3>
                    <button type="button" @click="createOpen = false" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Slug') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" required placeholder="e.g. posts.create" class="w-full rounded-lg border-gray-300 text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Group') }}</label>
                        <input type="text" name="group" placeholder="e.g. posts" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-2">
                    <button type="button" @click="createOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="editOpen" x-transition.opacity @click="editOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="editOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <form method="POST" :action="`/admin/permissions/${currentPermission.id}`">
                @csrf
                @method('PUT')
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Edit Permission') }}</h3>
                    <button type="button" @click="editOpen = false" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="currentPermission.name" required class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Slug') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="slug" x-model="currentPermission.slug" required class="w-full rounded-lg border-gray-300 text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Group') }}</label>
                        <input type="text" name="group" x-model="currentPermission.group" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-2">
                    <button type="button" @click="editOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</button>
                    <button type="submit" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Roles Modal -->
    <div x-show="rolesOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="rolesOpen" x-transition.opacity @click="rolesOpen = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
        <div x-show="rolesOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Assign Roles') }}</h3>
                    <p class="text-xs text-gray-500" x-text="currentPermission.name"></p>
                </div>
                <button type="button" @click="rolesOpen = false" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="p-6 space-y-3 max-h-96 overflow-y-auto">
                <template x-for="role in availableRoles" :key="role.id">
                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                        <input type="checkbox" x-model="role.assigned" class="rounded border-gray-300 text-rj-purple focus:ring-rj-purple">
                        <div>
                            <div class="text-sm font-bold text-gray-900" x-text="role.name"></div>
                            <div class="text-xs text-gray-500 font-mono" x-text="role.slug"></div>
                        </div>
                    </label>
                </template>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-2">
                <button type="button" @click="rolesOpen = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</button>
                <button type="button" @click="syncRoles()" class="px-4 py-2 bg-rj-purple text-white rounded-lg text-sm font-bold hover:bg-rj-purple/90">{{ __('Save Assignments') }}</button>
            </div>
        </div>
    </div>

</div>
@endsection
