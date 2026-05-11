@extends('layouts.guest')
@section('title', 'Create Account')

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
            <h1 class="text-xl font-bold text-slate-900 dark:text-white">Create your account</h1>
            <p class="text-sm text-slate-400 mt-1">Join thousands of students sharing knowledge</p>
        </div>

        @if($errors->any())
            <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl px-4 py-3 space-y-1">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">First name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                           class="input-field" placeholder="John">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Last name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                           class="input-field" placeholder="Doe">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Username</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">@</span>
                    <input type="text" name="username" value="{{ old('username') }}" required
                           class="input-field pl-7" placeholder="johndoe">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="input-field" placeholder="you@example.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                <input type="password" name="password" required
                       class="input-field" placeholder="Min. 8 characters">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Confirm password</label>
                <input type="password" name="password_confirmation" required
                       class="input-field" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full py-2.5 rounded-xl text-sm mt-2">
                Create Account
            </button>

            <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                By signing up, you agree to our <a href="#" class="underline">Terms of Service</a> and <a href="#" class="underline">Privacy Policy</a>.
            </p>
        </form>

        <p class="mt-6 text-center text-sm text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-sn-600 font-semibold hover:underline dark:text-sn-300">Sign in</a>
        </p>
    </div>

</div>
@endsection