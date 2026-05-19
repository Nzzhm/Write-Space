<x-app-layout>

    <div class="max-w-6xl mx-auto px-6 mt-4 mb-2">
    <!-- Garis pembatas atas -->
    <div class=" pt-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <h1 class="font-serif font-bold text-5xl md:text-6xl text-black tracking-tight">
                Write Space
            </h1>
            <p class="font-sans mt-2 text-sm md:text-base text-gray-500">
                A space for reading, writing, and sharing inspiration.
            </p>
        </div>
        
        <!-- Informasi otomatis dari Laravel -->
        <div class="font-sans text-xs uppercase tracking-widest text-gray-700 font-medium">
            Today : {{ now()->isoFormat('D MMMM YYYY') }}
        </div>
    </div>
</div>


    {{-- ===== HERO SECTION ===== --}}
    @if ($hero)
    <section class="max-w-6xl mx-auto px-6 pt-12 mb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            {{-- Gambar --}}
            <div class="lg:col-span-7">
                @if ($hero->thumbnail)
                <a href="{{ route('articles.show', $hero) }}">
                    <img src="{{ asset('storage/' . $hero->thumbnail) }}"
                         class="max-w-md hover:grayscale-0 transition duration-300 aspect-[4/5] object-cover grayscale">
                </a>
                @else
                    <div class="w-full aspect-[4/5] bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif
            </div>

            {{-- Teks --}}
            <div class="lg:col-span-5 lg:pl-8">
                @if ($hero->category)
                    <a href="{{ route('categories.show', $hero->category->slug) }}"
                       class="text-xs tracking-widest duration-300 uppercase text-gray-500 font-bold mb-2 block hover:text-black">
                        {{ $hero->category->name }}
                    </a>
                @endif

                <a href="{{ route('articles.show', $hero)  }}">
                <h1 class="hover:underline transition  duration-500 font-serif text-5xl font-semibold leading-tight mb-6">
                    {{ $hero->title }}
                </h1>
                </a>

                <p class="text-gray-600 text-lg mb-6">
                    {{ Str::limit(strip_tags($hero->body), 150) }}
                </p>

                <div class="flex items-center gap-2 border-t border-gray-200 pt-4 text-xs tracking-widest uppercase text-gray-500">
                    <span>By {{ $hero->user->name }}</span>
                    <span>·</span>
                    <span>{{ $hero->created_at->diffForHumans() }}</span>
                </div>
            </div>

        </div>
    </section>
    @endif

    {{-- ===== LATEST NEWS ===== --}}
    <section class="max-w-6xl mx-auto px-6 mb-24">
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-serif text-2xl font-semibold">Latest News</h2>
            <a href="{{ route('articles.all') }}" class="text-xs tracking-widest uppercase hover:underline">View All Articles</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($latest as $article)
            <a href="{{ route('articles.show', $article) }}" class="group">
                @if ($article->thumbnail)
                    <img src="{{ asset('storage/' . $article->thumbnail) }}"
                         class="w-full aspect-square object-cover grayscale mb-4 transition hover:grayscale-0">
                @else
                    <div class="w-full aspect-square bg-gray-200 mb-4"></div>
                @endif

                @if ($article->category)
                    <p class="text-xs tracking-widest uppercase text-gray-500 mb-1">
                        {{ $article->category->name }}
                    </p>
                @endif

                <h3 class="font-serif text-xl font-bold mb-2 group-hover:underline">
                    {{ $article->title }}
                </h3>

                <p class="text-gray-500 text-sm">
                    {{ Str::limit(strip_tags($article->body), 100) }}
                </p>
            </a>
            @endforeach
        </div>
    </section>

    {{-- ===== QUOTE SECTION ===== --}}
    <section class="max-w-6xl mx-auto px-6 mb-24">
        <div class="bg-gray-50 border border-gray-200 py-16 px-8 text-center">
            <p class="text-4xl font-serif text-gray-300 mb-4">❞❞</p>
            <p class="font-serif text-2xl italic text-gray-800 max-w-2xl mx-auto mb-6">
                {{ $quoteText }}
            </p>
            <p class="text-xs tracking-widest uppercase text-gray-500">
                {{ $quoteAuthor }}
            </p>
        </div>
    </section>

    {{-- ===== EDITOR'S CHOICE ===== --}}
    @if ($editorsChoice->count())
    <section class="max-w-6xl mx-auto px-6">
        <h2 class="font-serif text-2xl font-semibold mb-8">Editor's Choice</h2>

        @foreach ($editorsChoice as $i => $article)
        <div class="flex items-start gap-6 border-t border-gray-200 py-8">
            <span class="font-serif text-5xl text-gray-200 font-bold leading-none w-16 shrink-0">
                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
            </span>
            <div class="flex-1">
                @if ($article->category)
                    <p class="text-xs tracking-widest uppercase text-gray-500 mb-1">
                        {{ $article->category->name }}
                    </p>
                @endif
                <h3 class="font-serif text-2xl font-medium mb-2">
                    <a href="{{ route('articles.show', $article) }}" class="hover:underline">
                        {{ $article->title }}
                    </a>
                </h3>
                <p class="text-gray-500 text-sm">
                    {{ Str::limit(strip_tags($article->body), 120) }}
                </p>
            </div>
            <a href="{{ route('articles.show', $article) }}"
               class="text-xs tracking-widest uppercase border border-black px-4 py-2 hover:bg-black hover:text-white transition shrink-0">
                Read Article
            </a>
        </div>
        @endforeach
    </section>
    @endif


</x-app-layout>