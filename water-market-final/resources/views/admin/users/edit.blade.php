@extends('layouts.app')

@section('title', 'Edit Account')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline flex items-center gap-2 mb-4">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to User Management
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Account: {{ $user->name }}</h1>
        <p class="text-slate-500">Update account details for this user.</p>
    </div>

    <div class="bg-white rounded-[40px] shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700">
                    @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700">
                    @error('email') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Phone -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Contact Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 09171234567"
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700">
                    @error('phone') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">System Role</label>
                    <select name="role" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-black text-slate-700 appearance-none">
                        <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Address</label>
                <textarea name="address" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-[32px] focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700 h-28 resize-none">{{ old('address', $user->address) }}</textarea>
                @error('address') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-8 border-t border-slate-50 space-y-6">
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-2">Change Password</h3>
                    <p class="text-xs text-slate-400 font-medium">Leave blank if you don't want to change the password.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password</label>
                        <input type="password" name="password" 
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700">
                        @error('password') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700">
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-6 bg-[#0a56f1] text-white font-black rounded-[32px] shadow-2xl shadow-blue-200 hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Update Account Details
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
