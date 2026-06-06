<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Water Market | Premium Water Refilling Station</title>
        <!-- Tailwind CSS via CDN for demonstration -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .bg-grid {
                background-image: radial-gradient(circle at 2px 2px, #e2e8f0 1px, transparent 0);
                background-size: 40px 40px;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900">
        <div class="relative min-h-screen bg-grid">
            <!-- Navigation -->
            <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">WM</div>
                            <span class="text-xl font-extrabold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent tracking-tight">
                                Water Market
                            </span>
                        </div>
                        
                        <div class="hidden md:flex items-center gap-8">
                            <a href="#features" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Features</a>
                            <a href="#about" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">About</a>
                            <a href="#contact" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Contact</a>
                        </div>

                        <div class="flex items-center gap-3">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-white bg-blue-600 px-5 py-2.5 rounded-full hover:bg-blue-700 transition shadow-md shadow-blue-100">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:text-blue-600 px-4 py-2 transition-colors">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="text-sm font-bold text-white bg-slate-900 px-5 py-2.5 rounded-full hover:bg-slate-800 transition shadow-lg shadow-slate-200">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <header class="pt-20 pb-16 px-4">
                <div class="max-w-7xl mx-auto text-center">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 mb-8 animate-bounce">
                        <span class="flex h-2 w-2 rounded-full bg-blue-600"></span>
                        <span class="text-xs font-bold text-blue-700 uppercase tracking-widest">Pure. Clean. Refreshing.</span>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 tracking-tight">
                        Quality Water for your <br/>
                        <span class="bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">Everyday Needs</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-lg text-slate-500 leading-relaxed mb-10">
                        Experience the most convenient way to manage your water refills. Secure ordering, real-time tracking, and doorstep delivery for your home and office.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition shadow-xl shadow-blue-200">
                            Place an Order
                        </a>
                        <a href="#features" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition">
                            Learn More
                        </a>
                    </div>
                </div>
            </header>

            <!-- Stats -->
            <section class="py-12 px-4 bg-white/50 border-y border-slate-200">
                <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-slate-900">5,000+</p>
                        <p class="text-sm text-slate-500 font-medium">Daily Gallons</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-slate-900">1,200+</p>
                        <p class="text-sm text-slate-500 font-medium">Active Households</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-slate-900">15 min</p>
                        <p class="text-sm text-slate-500 font-medium">Avg. Delivery</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-extrabold text-slate-900">4.9/5</p>
                        <p class="text-sm text-slate-500 font-medium">Customer Rating</p>
                    </div>
                </div>
            </section>

            <!-- About & Station Information -->
            <section id="about" class="py-24 px-4 bg-white/40">
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                        <div class="space-y-8">
                            <div class="inline-block px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest">Our Station</div>
                            <h2 class="text-4xl font-extrabold text-slate-900 leading-tight">Water Market Station</h2>
                            <p class="text-lg text-slate-600 leading-relaxed">
                                Your reliable source of clean, safe, and affordable purified water in **Hinunangan, Southern Leyte**. We serve the community with quality water refills delivered right to your doorstep.
                            </p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-4">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2 text-blue-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <span class="font-bold text-sm uppercase tracking-wider">Station Address</span>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                                        Purok Saging, Brgy. Panalaron,<br/> Hinunangan, Southern Leyte
                                    </p>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2 text-blue-600">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="font-bold text-sm uppercase tracking-wider">Operating Hours</span>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                                        Monday–Saturday: 7:00 AM – 6:00 PM<br/>
                                        <span class="text-rose-400">Sunday: Closed</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute -inset-4 bg-blue-600/5 rounded-[40px] blur-3xl"></div>
                            <div class="relative bg-white p-2 rounded-[40px] shadow-2xl border border-slate-100 overflow-hidden">
                                <div class="bg-slate-50 rounded-[32px] p-10 flex flex-col items-center justify-center text-center space-y-6">
                                    <div class="w-20 h-20 bg-blue-600 rounded-3xl flex items-center justify-center text-white shadow-xl shadow-blue-200">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-black text-slate-900 leading-tight">Serving Hinunangan<br/>Since 2025</p>
                                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-3">Quality Assured</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features -->
            <section id="features" class="py-24 px-4 max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Why Choose Water Market?</h2>
                    <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full shadow-lg shadow-blue-100"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-10 bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-8 shadow-inner">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-4">Ultra-Purified</h3>
                        <p class="text-slate-500 leading-relaxed text-sm font-medium">Our 24-stage filtration process ensures the highest quality drinking water for your safety.</p>
                    </div>
                    <div class="p-10 bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 mb-8 shadow-inner">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-4">Instant Delivery</h3>
                        <p class="text-slate-500 leading-relaxed text-sm font-medium">Automated dispatch system ensures your water arrives within minutes of your request.</p>
                    </div>
                    <div class="p-10 bg-white rounded-[40px] border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                        <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-8 shadow-inner">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-4">Easy Tracking</h3>
                        <p class="text-slate-500 leading-relaxed text-sm font-medium">Real-time GPS tracking for every delivery. Know exactly when your refill is at the door.</p>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section id="contact" class="py-24 px-4 bg-slate-50">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <div class="inline-block px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest mb-4">Contact Us</div>
                        <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Get in Touch</h2>
                        <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full mt-4"></div>
                        <p class="mt-6 text-slate-500 max-w-2xl mx-auto">Have questions or feedback? Send us a message and our team will get back to you shortly.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <!-- Contact Info -->
                        <div class="space-y-8">
                            <div class="p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm flex items-start gap-6">
                                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shrink-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.79 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-widest mb-2">Phone</h4>
                                    <p class="text-slate-500 font-bold">0917-123-4567</p>
                                    <p class="text-slate-400 text-xs mt-1">Available 7am - 6pm</p>
                                </div>
                            </div>

                            <div class="p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm flex items-start gap-6">
                                <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 shrink-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 uppercase text-xs tracking-widest mb-2">Email</h4>
                                    <p class="text-slate-500 font-bold">contact@watermarket.com</p>
                                    <p class="text-slate-400 text-xs mt-1">Support anytime</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div class="lg:col-span-2">
                            <div class="bg-white p-10 rounded-[40px] shadow-xl border border-slate-100">
                                @if(session('success'))
                                    <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        <span class="font-bold text-sm">{{ session('success') }}</span>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="mb-8 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                        <span class="font-bold text-sm">{{ session('error') }}</span>
                                    </div>
                                @endif

                                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Your Name</label>
                                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700" placeholder="John Doe">
                                            @error('name') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700" placeholder="john@example.com">
                                            @error('email') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Subject</label>
                                        <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700" placeholder="How can we help?">
                                        @error('subject') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Message</label>
                                        <textarea name="message" required class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700 h-32 resize-none" placeholder="Type your message here...">{{ old('message') }}</textarea>
                                        @error('message') <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                                    </div>

                                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-[32px] shadow-2xl shadow-blue-200 hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polyline points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                        Send Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="py-12 px-4 border-t border-slate-200 bg-white">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">WM</div>
                        <span class="text-lg font-bold text-slate-900">Water Market</span>
                    </div>
                    <p class="text-slate-400 text-sm">© {{ date('Y') }} Water Market Station. All rights reserved.</p>
                    <div class="flex gap-6 text-slate-400 text-sm">
                        <a href="#" class="hover:text-blue-600">Privacy Policy</a>
                        <a href="#" class="hover:text-blue-600">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
