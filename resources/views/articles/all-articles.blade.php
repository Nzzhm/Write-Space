<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-12">

        {{-- ===== HEADER + SEARCH ===== --}}
        <div class="flex flex-wrap items-start justify-between gap-4 mb-8">
            <div>
                <h1 class="font-serif text-5xl font-semibold mb-2">All Article</h1>
                <p class="text-gray-500">A collection of thoughts, culture, and architecture.</p>
            </div>
            <form method="GET" action="{{ route('articles.all') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Find specific stories..."
                       class="border px-3 py-2 text-sm w-64">
                <button type="submit" class="uppercase tracking-wider border px-3 py-2 text-sm bg-black text-white hover:border-black hover:bg-white hover:text-black transition">
                    search
                </button>
            </form>
        </div>

        {{-- ===== TAB KATEGORI ===== --}}
        <div class="flex gap-6 border-b mb-10 overflow-x-auto">
            <a href="{{ route('articles.all') }}"
               class="pb-3 text-sm whitespace-nowrap {{ !request('category') ? 'border-b-2 border-black font-bold' : 'text-gray-500 hover:text-black' }}">
                All Work
            </a>
            @foreach($categories as $category)
                <a href="{{ route('articles.all', ['category' => $category->id]) }}"
                   class="pb-3 text-sm whitespace-nowrap {{ request('category') == $category->id ? 'border-b-2 border-black font-bold' : 'text-gray-500 hover:text-black' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- ===== FEATURED ARTIKEL ===== --}}
        @if($featured && !request('category') && !request('search'))
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div onclick="window.location='{{ route('articles.show', $featured) }}'" class="group cursor-pointer relative md:col-span-2">
                <span class="absolute top-3 left-3 bg-black text-white text-xs px-2 py-1 z-10 tracking-widest">
                    FEATURED
                </span>
                @if($featured->thumbnail)
                    <img src="{{ asset('storage/' . $featured->thumbnail) }}"
                         class="w-full aspect-[4/3] object-cover grayscale group-hover:grayscale-0 transition duration-300">
                @else
                    <div class="w-full aspect-[4/3] bg-gray-200"></div>
                @endif
                @if($featured->category)
                <div onclick="event.stopPropagation()"> 
                    <a href="{{ route('categories.show', $featured->category->slug) }}" class="text-xs tracking-widest uppercase text-gray-500 hover:text-black mt-3">
                        {{ $featured->category->name }}
                    </a>
                </div>
                @endif
                <h2 class="font-serif text-3xl font-medium mt-1 group-hover:underline">
                    {{ $featured->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-2">
                    {{ Str::limit(strip_tags($featured->body), 120) }}
                </p>
                <p class="text-xs text-gray-400 mt-2 tracking-widest uppercase">
                    {{ $featured->created_at->format('M d, Y') }}
                </p>
            </div>

            {{-- Artikel kedua di sebelah featured --}}
            @if($articles->first())
            
            <div onclick="window.location='{{ route('articles.show', $second) }}'" class="group cursor-pointer">
                @if($second->thumbnail)
                    <img src="{{ asset('storage/' . $second->thumbnail) }}"
                         class="w-full aspect-[4/3] object-cover grayscale group-hover:grayscale-0 transition duration-300">
                @else
                    <div class="w-full aspect-[4/3] bg-gray-200"></div>
                @endif
                @if($second->category)
                    <div onclick="event.stopPropagation()">
                        <a href="{{ route('categories.show', $second->category->slug) }}"
                        class="text-xs tracking-widest uppercase text-gray-500 mt-3 hover:text-black transition">
                            {{ $second->category->name }}
                        </a>
                    </div>
                @endif
                <p class="text-xs tracking-widest uppercase text-gray-500 mt-3"></p>
                <h2 class="font-serif text-2xl font-medium mt-1 group-hover:underline">
                    {{ $second->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-2">
                    {{ Str::limit(strip_tags($second->body), 100) }}
                </p>
                <p class="text-xs text-gray-400 mt-2 tracking-widest uppercase">
                    {{ $second->created_at->format('M d, Y') }}
                </p>
            </div>
            @endif
        </div>
        @endif

        {{-- ===== GRID ARTIKEL ===== --}}
        <section class="mb-16">
            @if($articles->count())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($articles as $article)
                    <div onclick="window.location='{{ route('articles.show', $article) }}'"
                         class="group cursor-pointer">
                        @if ($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                 class="w-full aspect-square object-cover grayscale group-hover:grayscale-0 transition duration-300">
                        @else
                            <div class="w-full aspect-square bg-gray-200"></div>
                        @endif
                        <div class="mt-4">
                            @if ($article->category)
                                <div onclick="event.stopPropagation()">
                                    <a href="{{ route('categories.show', $article->category->slug) }}"
                                       class="text-xs tracking-widest uppercase text-gray-500 hover:text-black transition">
                                        {{ $article->category->name }}
                                    </a>
                                </div>
                            @endif
                            <h3 class="font-serif text-xl font-medium mt-1 group-hover:underline">
                                {{ $article->title }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ Str::limit(strip_tags($article->body), 80) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2 tracking-widest uppercase">
                                {{ $article->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-24">Tidak ada artikel ditemukan.</p>
            @endif
        </section>

        {{-- ===== PAGINATION ===== --}}
        <div class="border-t pt-8">
            @if ($articles->hasPages())
                {{ $articles->appends(request()->query())->links() }}
            @endif
        </div>

    </div>
</x-app-layout>