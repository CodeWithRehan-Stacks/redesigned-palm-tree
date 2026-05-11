@extends('layouts.guest')
@section('title', 'Sign In')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#F5F5F5] dark:bg-[#0d1117] px-4 py-12">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="flex items-center gap-2.5 mb-8">
        <div class="w-10 h-10 bg-sn-300 rounded-xl flex items-center justify-center">
            <span class="material-symbols-rounded text-[22px] text-sn-900" style="font-variation-settings: 'FILL' 1">auto_stories</span>
        </div>
        <span class="text-xl font-bold text-slate-900 dark:text-white">ShareNote</span>
    </a>

    {{-- Card --}}
    <div class="w-full max-w-sm bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-8">
        <div class="mb-6 text-center">
            <h1 class="text-xl font-bold text-slate-900 dark:text-white">Welcome back</h1>
            <p class="text-sm text-slate-400 mt-1">Sign in to continue learning</p>
        </div>

        @if($errors->any())
            <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl px-4 py-3">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="input-field"
                       placeholder="you@example.com">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <a href="#" class="text-xs text-sn-600 hover:underline dark:text-sn-300">Forgot?</a>
                </div>
                <input type="password" name="password" required
                       class="input-field"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember"
                       class="w-4 h-4 rounded border-slate-300 text-sn-500 focus:ring-sn-300">
                <label for="remember" class="text-sm text-slate-600 dark:text-slate-400">Keep me signed in</label>
            </div>

            <button type="submit" class="btn-primary w-full mt-2 py-2.5 rounded-xl text-sm">
                Sign In
            </button>
        </form>

        {{-- Divider --}}
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white dark:bg-[#161b22] px-2 text-slate-400">Or continue with</span>
            </div>
        </div>

        {{-- Social Login --}}
        <button id="google-login" class="w-full flex items-center justify-center gap-2.5 bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 py-2.5 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                <path d="M1 1h22v22H1z" fill="none"/>
            </svg>
            Google
        </button>

        <p class="mt-6 text-center text-sm text-slate-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-sn-600 font-semibold hover:underline dark:text-sn-300">Sign up free</a>
        </p>
    </div>

</div>

{{-- Firebase SDK and Auth Logic --}}
<script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-auth-compat.js"></script>

<script>
    // These should ideally be in your .env and passed via config
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();
    const provider = new firebase.auth.GoogleAuthProvider();

    document.getElementById('google-login').addEventListener('click', () => {
        auth.signInWithPopup(provider).then((result) => {
            const user = result.user;
            
            // Send user data to your backend
            fetch("{{ route('auth.google') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    uid: user.uid,
                    email: user.email,
                    name: user.displayName,
                    photoURL: user.photoURL
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.href = "{{ route('home') }}";
                } else {
                    alert('Authentication failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }).catch((error) => {
            console.error(error.message);
        });
    });
</script>
@endsection