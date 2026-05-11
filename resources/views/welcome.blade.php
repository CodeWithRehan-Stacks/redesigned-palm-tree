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
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                <span class="text-2xl font-extrabold text-gradient tracking-tight">ShareNote</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Features</a>
                <a href="#community" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Community</a>
                <a href="#testimonials" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">Testimonials</a>
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
                Master your classes with <br class="hidden md:block"/>
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
                    <a href="#features" class="btn-secondary text-lg px-8 py-4 w-full sm:w-auto">Explore features</a>
                @endauth
            </div>
            
            <!-- Hero Dashboard Mockup -->
            <div class="mt-20 relative max-w-5xl mx-auto perspective-1000">
                <div class="glass-card p-2 md:p-4 rotate-x-12 shadow-[0_30px_60px_rgba(0,0,0,0.12)] border-white/60 relative transform-gpu hover:rotate-x-0 hover:scale-105 transition-all duration-700 ease-out">
                    <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?q=80&w=2000&auto=format&fit=crop" alt="App Dashboard Mockup" class="w-full h-auto rounded-2xl md:rounded-3xl shadow-inner border border-slate-100/50 object-cover object-top aspect-[16/9] opacity-90 mix-blend-luminosity hover:mix-blend-normal transition-all duration-700">
                    
                    <!-- Floating Elements -->
                    <div class="absolute -left-10 top-20 glass-panel p-4 rounded-2xl flex items-center gap-4 animate-blob">
                        <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
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

    <!-- Features Section -->
    <section id="features" class="py-24 relative z-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6">Everything you need to excel</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">ShareNote brings together powerful note-taking and community discussion in one seamless platform.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card group hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-blue-200/50">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Rich Note Sharing</h3>
                    <p class="text-slate-600 leading-relaxed">Upload PDFs, Docs, or create rich text notes directly. Categorize with tags and share them publicly or privately with your followers.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-card group hover:-translate-y-2">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-purple-200/50">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Note Raise System</h3>
                    <p class="text-slate-600 leading-relaxed">Quote specific sections of notes, ask questions, and spark discussions. Interact through a dynamic, infinite-scrolling social feed.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-card group hover:-translate-y-2">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-sm border border-indigo-200/50">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Trending Algorithms</h3>
                    <p class="text-slate-600 leading-relaxed">Discover the most popular notes and trending topics in your university or across the entire platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-24 relative z-10 px-6">
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
    <footer class="glass-panel border-t border-white/40 pt-16 pb-8 relative z-10 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                    <span class="text-xl font-extrabold text-gradient">ShareNote</span>
                </div>
                <p class="text-slate-500 text-sm">Empowering students through collective knowledge and seamless sharing.</p>
            </div>
            
            <div>
                <h4 class="font-bold text-slate-900 mb-4">Platform</h4>
                <ul class="space-y-3 text-sm text-slate-500">
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Explore Notes</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Trending Raises</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Categories</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold text-slate-900 mb-4">Company</h4>
                <ul class="space-y-3 text-sm text-slate-500">
                    <li><a href="#" class="hover:text-blue-600 transition-colors">About Us</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Careers</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold text-slate-900 mb-4">Legal</h4>
                <ul class="space-y-3 text-sm text-slate-500">
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto pt-8 border-t border-slate-200/60 text-center text-sm text-slate-500">
            &copy; {{ date('Y') }} ShareNote Inc. All rights reserved. Built with Laravel & Tailwind.
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