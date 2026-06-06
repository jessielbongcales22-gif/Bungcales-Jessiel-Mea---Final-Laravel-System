<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Water Market') }} - @yield('title', 'Refilling Station')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-[#f4f7fe] text-slate-900">
    @auth
        <!-- Sidebar Layout for All Auth Users -->
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside class="w-64 bg-[#8b191e] text-white flex flex-col fixed inset-y-0 left-0 z-50">
                <div class="p-6 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md text-white">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-black text-lg leading-tight uppercase tracking-tighter text-white">Water Market</h2>
                            <p class="text-[10px] text-white/60 font-bold uppercase tracking-widest">{{ Auth::user()->role }} Portal</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 px-4 space-y-2">
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('*.dashboard') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            <span class="font-bold text-sm">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.walkin.create') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.walkin.*') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                            <span class="font-bold text-sm">Walk-in Sale</span>
                        </a>

                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('orders.index') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <div class="flex items-center gap-3">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                <span class="font-bold text-sm">Orders</span>
                            </div>
                            <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">{{ \App\Models\Order::where('status', 'pending')->count() }}</span>
                        </a>

                        <a href="{{ route('inventory.index') }}" 
                           class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('inventory.*') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <div class="flex items-center gap-3">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                <span class="font-bold text-sm">Inventory</span>
                            </div>
                            <span class="text-[10px] font-black bg-white/20 px-2 py-0.5 rounded-full">{{ \App\Models\Inventory::where('quantity', '<', 50)->count() }}</span>
                        </a>

                        <a href="{{ route('admin.reports.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20v-6"/><path d="M6 20V10"/><path d="M18 20V4"/></svg>
                            <span class="font-bold text-sm">Reports</span>
                        </a>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span class="font-bold text-sm">Users</span>
                            </a>

                            <a href="{{ route('admin.settings.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                <span class="font-bold text-sm">Settings</span>
                            </a>
                        @endif
                    @else
                        <!-- Customer Sidebar Links -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            <span class="font-bold text-sm">Home</span>
                        </a>

                        <a href="{{ route('orders.create') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('orders.create') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                            <span class="font-bold text-sm">Order Refill</span>
                        </a>

                        <a href="{{ route('orders.index') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('orders.index') ? 'bg-white/10 shadow-inner' : 'hover:bg-white/5' }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            <span class="font-bold text-sm">My Orders</span>
                        </a>
                    @endif
                </nav>

                <div class="p-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-white/60 hover:text-white hover:bg-white/5 transition-all text-white">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            <span class="font-bold text-sm">Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 ml-64 flex flex-col">
                <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40">
                    <h2 class="font-bold text-slate-800 tracking-tight">@yield('title', 'Refilling Station')</h2>
                    
                    <div class="flex items-center gap-6">
                        <button class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </button>
                        <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 border border-slate-200">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="p-8 flex-1">
                    <!-- Global Notifications -->
                    @if(session('success'))
                        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <span class="font-bold text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <!-- Guest Layout -->
        <main>@yield('content')</main>
    @endauth
</body>
</html>
