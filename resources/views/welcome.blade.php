<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ShareNote') }} - The Ultimate Social Learning Platform</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#f4f7fc] text-slate-900 font-sans antialiased selection:bg-blue-300 selection:text-blue-900 overflow-x-hidden min-h-screen">

    <!-- Ambient Background -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-blue-500/20 mix-blend-multiply filter blur-[120px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[40%] rounded-full bg-purple-500/20 mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[40%] h-[40%] rounded-full bg-indigo-500/20 mix-blend-multiply filter blur-[120px] animate-blob animation-delay-4000"></div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMTQ4LCAxNjMsIDE4NCwgMC4xNSkiLz48L3N2Zz4=')] opacity-60 [mask-image:radial-gradient(ellipse_at_center,black,transparent_80%)]"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-panel border-b border-white/40">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div style="display: flex; align-items: center; gap: 0.625rem;">
                <div class="w-8 h-8 bg-sn-300 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-rounded text-[18px] text-sn-900" style="font-variation-settings: 'FILL' 1">auto_stories</span>
                </div>
                <span class="text-[17px] font-bold text-slate-900 dark:text-white tracking-tight">ShareNote</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#faq" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">FAQ</a>
                <a href="#features" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Features</a>
                <a href="#cta" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Join</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                <a href="{{ route('home') }}" class="btn-primary">Go to Feed</a>
                @else
                <a href="{{ route('login') }}" class="text-slate-700 font-semibold hover:text-blue-600 transition-colors hidden sm:block">Sign In</a>
                <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-40 pb-20 lg:pt-48 lg:pb-32 overflow-hidden px-6">
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel border-white/60 shadow-sm text-sm font-semibold text-blue-700 mb-8 animate-bounce">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                The #1 Learning Community for Students
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-8 max-w-4xl mx-auto">
                Master your classes with <br class="hidden md:block" />
                <span class="text-gradient">collective knowledge.</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-600 mb-12 max-w-2xl mx-auto leading-relaxed">
                ShareNote combines the best of social networking with powerful note-taking. Share PDFs, start discussions, and learn from top students around the world.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                <a href="{{ route('home') }}" class="btn-primary text-lg px-8 py-4 w-full sm:w-auto">Open Application</a>
                @else
                <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4 w-full sm:w-auto">Join for free</a>
                <a href="#faq" class="btn-secondary text-lg px-8 py-4 w-full sm:w-auto">Explore FAQ</a>
                @endauth
            </div>

            <!-- Hero Dashboard Mockup -->
            <div class="mt-20 relative max-w-5xl mx-auto perspective-1000">
                <div class="glass-card p-2 md:p-4 rotate-x-12 shadow-[0_30px_60px_rgba(0,0,0,0.12)] border-white/60 relative transform-gpu hover:rotate-x-0 hover:scale-105 transition-all duration-700 ease-out">
                    <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=2000&auto=format&fit=crop" alt="App Dashboard Mockup" class="w-full h-auto rounded-2xl md:rounded-3xl shadow-inner border border-slate-100/50 object-cover object-top aspect-[16/9] opacity-90 mix-blend-luminosity hover:mix-blend-normal transition-all duration-700">

                    <!-- Floating Elements -->
                    <div class="absolute -left-10 top-20 glass-panel p-4 rounded-2xl flex items-center gap-4 animate-blob">
                        <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Notes Downloaded</p>
                            <p class="text-sm text-slate-500">1.2k this week</p>
                        </div>
                    </div>

                    <div class="absolute -right-10 bottom-20 glass-panel p-4 rounded-2xl flex items-center gap-4 animate-blob animation-delay-2000">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=A&background=random" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=B&background=random" alt="">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=C&background=random" alt="">
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Active Discussions</p>
                            <p class="text-sm text-slate-500">Join 340+ students</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section - Accordion Cards -->
    <section id="faq" class="py-24 relative z-10 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6">Everything you need to know</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Click on any card to explore ShareNote's features, community, testimonials, and important information.</p>
            </div>

            <div x-data="{active: 0}" class="space-y-6">
                <!-- Features Card -->
                <div class="glass-card border border-white/50 transition-all duration-300" :class="active === 0 ? 'shadow-xl scale-[1.02]' : 'hover:scale-[1.01]'">
                    <button @click="active = active === 0 ? null : 0" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center transition-transform duration-300" :class="active === 0 ? 'scale-110' : 'group-hover:scale-105'">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Features</h3>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 transition-transform duration-300" :class="active === 0 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-8 pb-6 text-slate-600 leading-relaxed border-t border-slate-100/80 pt-6">
                        <div class="grid sm:grid-cols-3 gap-6">
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Rich Note Sharing</h4>
                                <p>Upload PDFs, Docs, or create rich text notes with tags and share them publicly or privately.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Note Raise System</h4>
                                <p>Quote specific sections, ask questions, and spark discussions through an infinity-scrolling social feed.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 mb-2">Trending Algorithms</h4>
                                <p>Discover the most popular notes and trending topics in your university or across the entire platform.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Community Card -->
                <div class="glass-card border border-white/50 transition-all duration-300" :class="active === 1 ? 'shadow-xl scale-[1.02]' : 'hover:scale-[1.01]'">
                    <button @click="active = active === 1 ? null : 1" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center transition-transform duration-300" :class="active === 1 ? 'scale-110' : 'group-hover:scale-105'">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Community</h3>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-8 pb-6 text-slate-600 leading-relaxed border-t border-slate-100/80 pt-6">
                        <p class="mb-4">Join a vibrant network of students who are passionate about learning together. Our community offers study groups, live discussions, and peer-to-peer support 24/7.</p>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center gap-2"><span class="w-2 h-2 bg-purple-400 rounded-full"></span> 340+ active discussions daily</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 bg-purple-400 rounded-full"></span> 12,000+ verified students across 150 universities</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 bg-purple-400 rounded-full"></span> Moderated & safe environment</li>
                        </ul>
                    </div>
                </div>

                <!-- Testimonials Card -->
                <div class="glass-card border border-white/50 transition-all duration-300" :class="active === 2 ? 'shadow-xl scale-[1.02]' : 'hover:scale-[1.01]'">
                    <button @click="active = active === 2 ? null : 2" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center transition-transform duration-300" :class="active === 2 ? 'scale-110' : 'group-hover:scale-105'">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Testimonials</h3>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-8 pb-6 text-slate-600 leading-relaxed border-t border-slate-100/80 pt-6">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div class="bg-white/60 p-4 rounded-xl border border-slate-100">
                                <p class="italic mb-3">"ShareNote completely transformed the way I study. I can finally find organized notes and ask questions directly on the content."</p>
                                <p class="font-semibold text-sm text-slate-900">Alexandra M.</p>
                                <p class="text-xs text-slate-400">Computer Science, MIT</p>
                            </div>
                            <div class="bg-white/60 p-4 rounded-xl border border-slate-100">
                                <p class="italic mb-3">"The trending notes feature helps me discover resources I never knew existed. It's like a social network for learning."</p>
                                <p class="font-semibold text-sm text-slate-900">James L.</p>
                                <p class="text-xs text-slate-400">Medicine, Stanford</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Platform Card -->
                <div class="glass-card border border-white/50 transition-all duration-300" :class="active === 3 ? 'shadow-xl scale-[1.02]' : 'hover:scale-[1.01]'">
                    <button @click="active = active === 3 ? null : 3" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center transition-transform duration-300" :class="active === 3 ? 'scale-110' : 'group-hover:scale-105'">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Platform</h3>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-8 pb-6 text-slate-600 leading-relaxed border-t border-slate-100/80 pt-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <a href="#" class="p-4 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all group">
                                <h4 class="font-semibold text-slate-900 group-hover:text-blue-600">Explore Notes</h4>
                                <p class="text-sm text-slate-500">Browse thousands of shared notes</p>
                            </a>
                            <a href="#" class="p-4 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all group">
                                <h4 class="font-semibold text-slate-900 group-hover:text-blue-600">Trending Raises</h4>
                                <p class="text-sm text-slate-500">See what's hot in your field</p>
                            </a>
                            <a href="#" class="p-4 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all group">
                                <h4 class="font-semibold text-slate-900 group-hover:text-blue-600">Categories</h4>
                                <p class="text-sm text-slate-500">Organized subjects & topics</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Company Card -->
                <div class="glass-card border border-white/50 transition-all duration-300" :class="active === 4 ? 'shadow-xl scale-[1.02]' : 'hover:scale-[1.01]'">
                    <button @click="active = active === 4 ? null : 4" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center transition-transform duration-300" :class="active === 4 ? 'scale-110' : 'group-hover:scale-105'">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Company</h3>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 transition-transform duration-300" :class="active === 4 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-8 pb-6 text-slate-600 leading-relaxed border-t border-slate-100/80 pt-6">
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="px-6 py-3 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all font-medium text-slate-900 hover:text-blue-600">About Us</a>
                            <a href="#" class="px-6 py-3 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all font-medium text-slate-900 hover:text-blue-600">Careers</a>
                            <a href="#" class="px-6 py-3 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all font-medium text-slate-900 hover:text-blue-600">Contact</a>
                        </div>
                    </div>
                </div>

                <!-- Legal Card -->
                <div class="glass-card border border-white/50 transition-all duration-300" :class="active === 5 ? 'shadow-xl scale-[1.02]' : 'hover:scale-[1.01]'">
                    <button @click="active = active === 5 ? null : 5" class="w-full px-8 py-6 flex items-center justify-between text-left group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center transition-transform duration-300" :class="active === 5 ? 'scale-110' : 'group-hover:scale-105'">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Legal</h3>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 transition-transform duration-300" :class="active === 5 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-8 pb-6 text-slate-600 leading-relaxed border-t border-slate-100/80 pt-6">
                        <div class="flex flex-wrap gap-4">
                            <a href="#" class="px-6 py-3 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all font-medium text-slate-900 hover:text-blue-600">Privacy Policy</a>
                            <a href="#" class="px-6 py-3 bg-white/60 rounded-xl border border-slate-100 hover:border-blue-300 hover:shadow-md transition-all font-medium text-slate-900 hover:text-blue-600">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section id="cta" class="py-24 relative z-10 px-6">
        <div class="max-w-5xl mx-auto glass-card border border-blue-200/50 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-purple-600/5 to-indigo-600/10"></div>
            <div class="relative z-10 text-center py-12 px-6">
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6">Ready to ace your next exam?</h2>
                <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto">Join thousands of students who are already sharing notes and learning together.</p>
                <div class="flex justify-center">
                    <a href="{{ route('register') }}" class="btn-primary text-lg px-10 py-4 shadow-xl hover:shadow-2xl hover:scale-105 transition-all">Create your free account</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass-panel border-t border-white/40 pt-8 pb-8 relative z-10 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-8 h-8 bg-sn-300 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-rounded text-[18px] text-sn-900" style="font-variation-settings: 'FILL' 1">auto_stories</span>
                </div>
                <span class="text-[17px] font-bold text-slate-900 tracking-tight">ShareNote</span>
            </div>
            <p class="text-sm text-slate-500">&copy; {{ date('Y') }} ShareNote Inc. All rights reserved. Built with Laravel & Tailwind.</p>
        </div>
    </footer>

    <style>
        .perspective-1000 {
            perspective: 1000px;
        }

        .rotate-x-12 {
            transform: rotateX(12deg);
        }
    </style>
</body>

</html>