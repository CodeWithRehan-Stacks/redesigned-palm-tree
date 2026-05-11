@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Admin Dashboard</h1>
        <p class="text-slate-500 dark:text-slate-400">Platform overview and management.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $statCards = [
                ['label' => 'Total Users', 'value' => $stats['total_users'], 'icon' => 'groups', 'color' => 'blue'],
                ['label' => 'Total Notes', 'value' => $stats['total_notes'], 'icon' => 'description', 'color' => 'indigo'],
                ['label' => 'Total Raises', 'value' => $stats['total_raises'], 'icon' => 'forum', 'color' => 'purple'],
                ['label' => 'Pending Reports', 'value' => $stats['pending_reports'], 'icon' => 'report', 'color' => 'red'],
            ];
        @endphp

        @foreach($statCards as $card)
        <div class="bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/20 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-rounded text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400">{{ $card['icon'] }}</span>
                </div>
            </div>
            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $card['label'] }}</div>
            <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ number_format($card['value']) }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Reports Section --}}
        <div class="bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/30">
                <h3 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-red-500">flag</span>
                    Recent Reports
                </h3>
                <a href="#" class="text-xs font-semibold text-sn-600 hover:underline">Manage All</a>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($activeReports as $report)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $report->reason }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">By {{ $report->user->name }} · {{ $report->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-md {{ $report->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ $report->status }}
                        </span>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <span class="material-symbols-rounded text-slate-300 text-4xl">check_circle</span>
                        <p class="text-slate-500 text-sm mt-2">No active reports. All clear!</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Error Log Section --}}
        <div class="bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/30">
                <h3 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-rounded text-amber-500">bug_report</span>
                    System Errors
                </h3>
                <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-[10px] font-bold text-slate-500 rounded-full">Laravel Log</span>
            </div>
            <div class="p-0 max-h-[350px] overflow-y-auto">
                @forelse($errors as $error)
                    <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800/50 last:border-0">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></div>
                            <pre class="text-[11px] text-slate-600 dark:text-slate-400 font-mono whitespace-pre-wrap leading-relaxed">{{ Str::limit($error, 300) }}</pre>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <span class="material-symbols-rounded text-slate-300 text-4xl">verified_user</span>
                        <p class="text-slate-500 text-sm mt-2">No errors logged recently. Platform is stable.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Recent Users Table --}}
    <div class="mt-8 bg-white dark:bg-[#161b22] border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
            <h3 class="font-bold text-slate-900 dark:text-white">Newly Joined Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase tracking-wider bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Joined</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($recentUsers as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" class="w-8 h-8 rounded-lg object-cover">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-100 text-blue-700 rounded-full capitalize">{{ $user->role }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-lg">
                                <span class="material-symbols-rounded text-[18px]">more_vert</span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
