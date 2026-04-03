<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen">
        <div id="panel-sidebar-backdrop" class="fixed inset-0 z-40 hidden bg-slate-900/40 md:hidden" aria-hidden="true"></div>

        <aside id="panel-sidebar"
            class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r border-slate-200 bg-white shadow-sm transition-transform duration-200 md:static md:z-0 md:translate-x-0 md:shadow-none">
            <div class="flex h-16 items-center gap-3 border-b border-slate-100 px-5">
                <a href="{{ $panelHome ?? route('admin.dashboard') }}" class="flex min-w-0 flex-1 items-center gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-sm font-bold text-white shadow-sm">SM</div>
                    <span class="truncate font-semibold tracking-tight text-slate-900">{{ config('app.name') }}</span>
                </a>
            </div>
            <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto px-3 py-4 text-sm">
                @include('layouts.partials.panel-sidebar')
            </nav>
            <div class="border-t border-slate-100 p-3">
                <p class="mb-2 px-1 text-[10px] font-semibold uppercase tracking-wider text-slate-400">Peran</p>
                <p class="mb-3 px-1 text-xs font-medium text-slate-600">
                    @if(auth()->user()->isAdmin()) Administrator
                    @elseif(auth()->user()->isPembimbing()) Pembimbing
                    @else Peserta magang
                    @endif
                </p>
                <div class="flex items-center gap-3 rounded-[10px] bg-slate-50 px-3 py-2.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="post" class="mt-2">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-[10px] border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex min-h-screen flex-1 flex-col md:min-w-0">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-3 border-b border-slate-200/80 bg-white/95 px-4 shadow-sm backdrop-blur supports-[backdrop-filter]:bg-white/80 md:px-6">
                <div class="flex min-w-0 flex-1 items-center gap-3">
                    <button type="button" id="panel-sidebar-toggle" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-[10px] border border-slate-200 bg-white text-slate-600 shadow-sm md:hidden" aria-label="Menu">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="relative hidden max-w-md flex-1 sm:block">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input type="search" name="q" placeholder="Cari data…" class="w-full rounded-[10px] border border-slate-200 bg-slate-50/80 py-2 pl-10 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20" disabled title="Segera hadir">
                        <kbd class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2 rounded border border-slate-200 bg-white px-1.5 py-0.5 text-[10px] font-medium text-slate-500 lg:inline">⌘K</kbd>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    @if(($panelNotifCount ?? 0) > 0 && ($panelNotifUrl ?? null))
                        <a href="{{ $panelNotifUrl }}" class="relative inline-flex h-10 w-10 items-center justify-center rounded-[10px] border border-slate-200 bg-white text-slate-600 shadow-sm" title="Notifikasi">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute -right-1 -top-1 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white">{{ $panelNotifCount > 9 ? '9+' : $panelNotifCount }}</span>
                        </a>
                    @else
                        <span class="relative inline-flex h-10 w-10 items-center justify-center rounded-[10px] border border-slate-200 bg-white text-slate-400 shadow-sm" title="Tidak ada notifikasi baru">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </span>
                    @endif
                    <details class="relative">
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-[10px] border border-slate-200 bg-white py-1.5 pl-1.5 pr-2 shadow-sm">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-xs font-semibold text-blue-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="hidden max-w-[120px] truncate text-sm font-medium text-slate-700 lg:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </summary>
                        <div class="absolute right-0 z-50 mt-2 w-52 rounded-[10px] border border-slate-200 bg-white py-1 shadow-lg">
                            <div class="border-b border-slate-100 px-3 py-2">
                                <p class="truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                            <span class="block px-3 py-2 text-xs uppercase tracking-wide text-slate-400">{{ auth()->user()->role }}</span>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </details>
                </div>
            </header>

            <div class="flex-1 px-4 py-5 md:px-6">
                <nav class="mb-4 flex flex-wrap items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
                    <a href="{{ $panelHome ?? '#' }}" class="hover:text-blue-600">Beranda</a>
                    <span class="text-slate-300">/</span>
                    <span class="font-medium text-slate-700">@yield('page_title', 'Dashboard')</span>
                </nav>

                @if(session('success'))
                    <div class="mb-4 rounded-[10px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-[10px] border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-[10px] border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        (function () {
            var sidebar = document.getElementById('panel-sidebar');
            var backdrop = document.getElementById('panel-sidebar-backdrop');
            var toggle = document.getElementById('panel-sidebar-toggle');
            function openNav() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            function closeNav() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            toggle && toggle.addEventListener('click', function () {
                if (sidebar.classList.contains('-translate-x-full')) openNav(); else closeNav();
            });
            backdrop && backdrop.addEventListener('click', closeNav);
            window.addEventListener('resize', function () {
                if (window.matchMedia('(min-width: 768px)').matches) closeNav();
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
