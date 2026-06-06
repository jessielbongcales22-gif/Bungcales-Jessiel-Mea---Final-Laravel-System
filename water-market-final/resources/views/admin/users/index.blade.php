@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{
    search: '',
    roleFilter: 'All Roles',
    users: [
        @foreach($users as $u)
        {
            id: {{ $u->id }},
            name: '{{ $u->name }}',
            email: '{{ $u->email }}',
            phone: '{{ $u->phone ?? 'N/A' }}',
            role: '{{ ucfirst($u->role) }}',
            orders_count: {{ $u->orders_count }},
            total_spent: {{ $u->orders_sum_total ?? 0 }},
            editUrl: '{{ route('admin.users.edit', $u->id) }}',
            deleteUrl: '{{ route('admin.users.destroy', $u->id) }}',
            isSelf: {{ $u->id == auth()->id() ? 'true' : 'false' }}
        },
        @endforeach
    ],
    get filteredUsers() {
        return this.users.filter(u => {
            const matchesSearch = u.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                u.email.toLowerCase().includes(this.search.toLowerCase());
            const matchesRole = this.roleFilter === 'All Roles' || u.role === this.roleFilter;
            return matchesSearch && matchesRole;
        })
    }
}">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Admin Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $adminCount }}</p>
                <p class="text-sm font-bold text-slate-400">Admins</p>
            </div>
        </div>

        <!-- Staff Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $staffCount }}</p>
                <p class="text-sm font-bold text-slate-400">Staff</p>
            </div>
        </div>

        <!-- Customer Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $customerCount }}</p>
                <p class="text-sm font-bold text-slate-400">Customers</p>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="flex flex-col md:flex-row items-center gap-4 mb-8">
        <div class="relative flex-1 w-full">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" x-model="search" placeholder="Search users..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm font-medium">
        </div>
        
        <select x-model="roleFilter" class="w-full md:w-48 px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm font-bold text-slate-700">
            <option>All Roles</option>
            <option>Admin</option>
            <option>Staff</option>
            <option>Customer</option>
        </select>

        <a href="{{ route('admin.users.create') }}" class="w-full md:w-auto px-6 py-3 bg-[#0a56f1] text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Account
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-20">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-8 py-5">User</th>
                        <th class="px-8 py-5">Contact</th>
                        <th class="px-8 py-5">Role</th>
                        <th class="px-8 py-5">Orders</th>
                        <th class="px-8 py-5">Total Spent</th>
                        <th class="px-8 py-5">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="user in filteredUsers" :key="user.id">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 border border-blue-100">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-black text-[#1e293b]" x-text="user.name"></p>
                                        <p class="text-[12px] text-slate-400 font-bold" x-text="user.email"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-sm font-bold text-slate-500" x-text="user.phone"></td>
                            <td class="px-8 py-5">
                                <span :class="{
                                    'bg-rose-50 text-rose-500': user.role === 'Admin',
                                    'bg-blue-50 text-blue-500': user.role === 'Staff',
                                    'bg-emerald-50 text-emerald-500': user.role === 'Customer'
                                }" class="px-3 py-1 rounded-lg text-xs font-black" x-text="user.role"></span>
                            </td>
                            <td class="px-8 py-5 text-sm font-bold text-slate-500" x-text="user.orders_count"></td>
                            <td class="px-8 py-5 text-sm font-black text-slate-900" x-text="'₱' + Number(user.total_spent).toLocaleString()"></td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3" x-show="!user.isSelf">
                                    <a :href="user.editUrl" class="p-2 text-blue-400 hover:bg-blue-50 rounded-lg transition-colors">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                    </a>
                                    <form :action="user.deleteUrl" method="POST" onsubmit="return confirm('Delete this account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-400 hover:bg-rose-50 rounded-lg transition-colors">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
