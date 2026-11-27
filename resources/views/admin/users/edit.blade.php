@extends('admin.layouts.app')

@section('title', __('Edit User'))

@section('content')
<div class="max-w-3xl mx-auto space-y-6 pb-12">
    
    {{-- Başlıq və Geri Qayıtma Düyməsi --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-6 h-6 text-rj-purple" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                {{ __('Edit User') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Update user details, change their role, or reset their password.') }}</p>
        </div>
        
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('Back to Users') }}
        </a>
    </div>

    {{-- Form Kartı --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Ad və Soyad --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Full Name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="e.g. John Doe"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rj-purple focus:ring-rj-purple text-sm transition-colors @error('name') border-red-500 @enderror">
                    @error('name') 
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- E-poçt --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Email Address') }}</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="e.g. john@example.com"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rj-purple focus:ring-rj-purple text-sm transition-colors @error('email') border-red-500 @enderror">
                    @error('email') 
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Şifrə --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('New Password') }}</label>
                    <input type="password" name="password" placeholder="Leave empty to keep current password"
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rj-purple focus:ring-rj-purple text-sm transition-colors @error('password') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Leave empty to keep current password') }}
                    </p>
                    @error('password') 
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Rol --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Role') }}</label>
                    <select name="role" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rj-purple focus:ring-rj-purple text-sm transition-colors cursor-pointer @error('role') border-red-500 @enderror">
                        <option value="user" @selected(old('role', $user->role) === 'user')>{{ __('Standard User') }}</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>{{ __('Administrator') }}</option>
                    </select>
                    @error('role') 
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">{{ __('Account Status') }}</label>
                    <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-rj-purple focus:ring-rj-purple text-sm transition-colors cursor-pointer @error('status') border-red-500 @enderror">
                        <option value="active" @selected(old('status', $user->status) === 'active')>{{ __('Active') }}</option>
                        <option value="inactive" @selected(old('status', $user->status) === 'inactive')>{{ __('Inactive') }}</option>
                    </select>
                    @error('status') 
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Düymələr --}}
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-rj-purple to-rj-pink text-white text-sm font-bold shadow-md hover:opacity-90 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Update User') }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection