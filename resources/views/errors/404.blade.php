@extends('layouts.guest')
@section('title', '404 — Page Not Found')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-[#F5F5F5] dark:bg-[#0d1117] px-4">

    <div class="text-center max-w-md">
        {{-- Illustration --}}
        <div class="w-20 h-20 bg-[#DFF1F1] dark:bg-[#1A3A3E]/30 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
            <span class="material-symbols-rounded text-[40px] text-[#5C919A]" style="font-variation-settings: 'FILL' 1">
                search_off
            </span>
        </div>

        {{-- Error code --}}
        <p class="text-[80px] font-black text-[#DFF1F1] dark:text-[#1A3A3E] leading-none mb-2 select-none">404</p>

        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">Page not found</h1>
        <p class="text-slate-500 dark:text-slate-400 text-[15px] leading-relaxed mb-8">
            Oops — the page you're looking for doesn't exist or has been moved.
            Let's get you back on track.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center gap-2 bg-slate-900 text-white font-semibold py-2.5 px-6 rounded-xl hover:bg-slate-800 transition-colors text-sm w-full sm:w-auto">
                <span class="material-symbols-rounded text-[18px]">home</span>
                Go Home
            </a>
            <button onclick="history.back()"
                    class="inline-flex items-center justify-center gap-2 bg-white dark:bg-[#161b22] text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold py-2.5 px-6 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors text-sm w-full sm:w-auto">
                <span class="material-symbols-rounded text-[18px]">arrow_back</span>
                Go Back
            </button>
        </div>
    </div>

</div>
@endsection
