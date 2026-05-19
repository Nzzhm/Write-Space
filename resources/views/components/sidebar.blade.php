<aside id="admin-sidebar"
       class="fixed top-0 left-0 h-screen w-64 bg-stone-900 text-stone-100 z-30
              -translate-x-full lg:translate-x-0
              transition-transform duration-300 flex flex-col">


    {{-- Brand --}}
    <div class="px-6 py-7 border-b border-stone-700/60">
        <a href="{{ route('articles.index') }}" target="_blank"
           class="font-serif text-xl font-medium tracking-tight text-white hover:text-stone-300 transition-colors">
            {{ config('app.name') }}
        </a>
        <p class="text-[0.65rem] tracking-[0.12em] uppercase text-stone-500 mt-0.5">Admin Panel</p>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-6 space-y-0.5 overflow-y-auto">

        @php
            $navItems = [
                [
                    'label' => 'Artikel',
                    'route' => 'admin.index',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>',
                ],
                [
                    'label' => 'Tags',
                    'route' => 'admin.tags',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>',
                ],
                [
                    'label' => 'Categories',
                    'route' => 'admin.categories',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />',
                ],
            ];
        @endphp

        @foreach($navItems as $item)
        @php $active = request()->routeIs($item['route']); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded text-sm transition-colors
                  {{ $active
                     ? 'bg-white/10 text-white font-medium'
                     : 'text-stone-400 hover:text-white hover:bg-white/5' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="shrink-0">
                {!! $item['icon'] !!}
            </svg>
            {{ $item['label'] }}
        </a>
        @endforeach

        {{-- Section divider --}}
        <div class="pt-4 pb-2 px-3">
            <p class="text-[0.6rem] tracking-[0.14em] uppercase text-stone-600">Site</p>
        </div>

        {{-- Link to public site --}}
        <a href="{{ route('articles.index') }}" target="_blank"
           class="flex items-center gap-3 px-3 py-2.5 rounded text-sm text-stone-400 hover:text-white hover:bg-white/5 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
            </svg>
            Lihat Situs
        </a>
    </nav>

    {{-- User + Logout --}}
    <div class="px-4 py-5 border-t border-stone-700/60">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-7 h-7 rounded-full bg-stone-600 flex items-center justify-center text-xs font-medium text-white shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[0.65rem] text-stone-500 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full text-left text-[0.7rem] tracking-widest uppercase text-stone-500 hover:text-red-400 transition-colors">
                Logout
            </button>
        </form>
    </div>
</aside>