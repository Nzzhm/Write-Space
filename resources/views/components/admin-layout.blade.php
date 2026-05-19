<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 font-sans antialiased">

    {{-- Mobile overlay --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/40 z-20 hidden lg:hidden"
         onclick="closeSidebar()"></div>

    <div class="flex min-h-screen">

        {{-- ── SIDEBAR ── --}}
        <x-sidebar />

        {{-- ── MAIN ── --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top bar (mobile only) --}}
            <header class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-stone-200 sticky top-0 z-10">
                <button onclick="openSidebar()" class="text-stone-500 hover:text-stone-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
                <span class="font-serif text-lg font-medium text-stone-900 tracking-tight">Admin</span>
                <div class="w-6"></div>{{-- spacer --}}
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-6 lg:p-10">

                {{-- Flash messages --}}
                @if(session('success'))
                <div id="flash-success" class="mb-6 bg-stone-900 text-white text-xs tracking-widest uppercase px-4 py-3 flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-4 opacity-60 hover:opacity-100">✕</button>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('admin-sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.remove('hidden');
        }
        function closeSidebar() {
            document.getElementById('admin-sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
        }

        // Auto-dismiss flash
        setTimeout(() => {
            const el = document.getElementById('flash-success');
            if (el) el.remove();
        }, 3500);
    </script>

</body>
</html>