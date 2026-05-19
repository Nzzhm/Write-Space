<x-app-layout>

    <div class="min-h-screen bg-stone-50">

        {{-- ── ARTICLE HEADER ── --}}
        <header class="max-w-2xl mx-auto px-6 pt-14 pb-8 text-center">

            {{-- Category --}}
            @if ($article->category)
            <div class="mb-5">
                <a href="{{ route('categories.show', $article->category->slug) }}"
                   class="text-[0.68rem] tracking-[0.14em] uppercase text-stone-400 hover:text-stone-700 transition-colors font-sans">
                    {{ $article->category->name }}
                </a>
            </div>
            @endif

            {{-- Title --}}
            <h1 class="font-serif text-4xl sm:text-5xl font-medium leading-[1.18] tracking-tight text-stone-900 mb-5">
                {{ $article->title }}
            </h1>

            {{-- Thin rule --}}
            <div class="w-8 h-px bg-stone-300 mx-auto mb-5"></div>

            {{-- Meta --}}
            <div class="flex items-center justify-center flex-wrap gap-x-2 gap-y-1 font-sans text-[0.72rem] uppercase tracking-wider text-stone-400">
                <span>{{ $article->user->name }}</span>
                <span class="text-stone-200">·</span>
                <span>{{ $article->created_at->format('F j, Y') }}</span>
                <span class="text-stone-200">·</span>
                <span>{{ number_format($article->views) }} views</span>
            </div>
        </header>

        {{-- ── HERO THUMBNAIL ── --}}
        @if ($article->thumbnail)
        <div class="max-w-4xl mx-auto px-6 mb-2">
            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full max-h-[560px] object-cover">
        </div>
        @endif

        {{-- ── BODY + SIDEBAR LAYOUT ── --}}
        <div class="max-w-4xl mx-auto px-6 py-10 flex gap-12">

            {{-- Share Sidebar --}}
            <aside class="hidden lg:flex flex-col items-center gap-5 pt-2 min-w-[2rem]">
                <div class="sticky top-24 flex flex-col items-center gap-4">

                    <button onclick="navigator.share ? navigator.share({title:'{{ addslashes($article->title) }}',url:window.location.href}) : navigator.clipboard.writeText(window.location.href)"
                            title="Share" class="text-stone-400 hover:text-stone-800 transition-colors cursor-pointer bg-transparent border-0 p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </button>

                    <button title="Bookmark" class="text-stone-400 hover:text-stone-800 transition-colors cursor-pointer bg-transparent border-0 p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>

                    <div class="w-px h-10 bg-stone-200"></div>

                    <span class="font-sans text-[0.6rem] tracking-widest text-stone-300 [writing-mode:vertical-rl]">
                        {{ number_format($article->views) }}
                    </span>
                </div>
            </aside>

            {{-- Article Body --}}
            <article class="flex-1 min-w-0">

                <div class="font-serif text-[1.175rem] leading-[1.85] text-stone-800
                            [&>p]:mt-6 [&>p:first-child]:mt-0
                            [&>p:first-child::first-letter]:float-left
                            [&>p:first-child::first-letter]:text-[4.5rem]
                            [&>p:first-child::first-letter]:font-light
                            [&>p:first-child::first-letter]:leading-[0.75]
                            [&>p:first-child::first-letter]:mr-[0.1em]
                            [&>p:first-child::first-letter]:mt-[0.08em]
                            [&>h2]:font-serif [&>h2]:text-2xl [&>h2]:font-medium [&>h2]:mt-10 [&>h2]:mb-3 [&>h2]:text-stone-900
                            [&>h3]:font-serif [&>h3]:text-xl [&>h3]:font-medium [&>h3]:mt-8 [&>h3]:mb-2 [&>h3]:text-stone-900
                            [&>blockquote]:pl-6 [&>blockquote]:border-l-2 [&>blockquote]:border-stone-900
                            [&>blockquote]:py-2 [&>blockquote]:my-8 [&>blockquote]:italic
                            [&>blockquote]:text-[1.35rem] [&>blockquote]:font-light [&>blockquote]:text-stone-600
                            [&>blockquote_cite]:block [&>blockquote_cite]:mt-3
                            [&>blockquote_cite]:font-sans [&>blockquote_cite]:not-italic
                            [&>blockquote_cite]:text-[0.65rem] [&>blockquote_cite]:tracking-[0.12em]
                            [&>blockquote_cite]:uppercase [&>blockquote_cite]:text-stone-400
                            [&>img]:w-full [&>img]:my-8
                            [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mt-4 [&>ul>li]:mt-2
                            [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mt-4 [&>ol>li]:mt-2">
                    {!! $article->body !!}
                </div>

                {{-- Tags --}}
                @if ($article->tags->count())
                <div class="mt-10 pt-8 border-t border-stone-200 flex flex-wrap gap-2">
                    @foreach ($article->tags as $tag)
                    <span class="font-sans text-[0.65rem] tracking-[0.1em] uppercase text-stone-500 bg-stone-100 px-3 py-1">
                        #{{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                {{-- Owner Actions --}}
                @if(auth()->check() && auth()->id() === $article->user_id)
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('articles.edit', $article) }}"
                       class="font-sans text-[0.72rem] tracking-[0.1em] uppercase text-stone-800 border border-stone-800 px-5 py-2 hover:bg-stone-800 hover:text-white transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="delete-btn font-sans text-[0.72rem] tracking-[0.1em] uppercase text-red-800 border border-red-800 px-5 py-2 hover:bg-red-800 hover:text-white transition-colors cursor-pointer bg-transparent">
                            Hapus
                        </button>
                    </form>
                </div>
                @endif

            </article>
        </div>

        {{-- ── BACK BUTTON ── --}}
        <div class="max-w-4xl mx-auto px-6 pb-12 lg:pl-[5.5rem]">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('articles.index') }}"
               class="inline-flex items-center gap-2 font-sans text-[0.72rem] tracking-[0.1em] uppercase text-stone-400 hover:text-stone-800 transition-colors group">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.5"
                     class="group-hover:-translate-x-1 transition-transform duration-200">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Kembali
            </a>
        </div>

        {{-- ── RELATED STORIES ── --}}
        @php
            $related = \App\Models\Article::where('category_id', $article->category_id)
                ->where('id', '!=', $article->id)
                ->with('category', 'user')
                ->latest()
                ->take(3)
                ->get();
        @endphp

        @if($related->count())
        <section class="bg-stone-100 py-16 mt-4">
            <div class="max-w-4xl mx-auto px-6">

                <div class="flex justify-between items-end mb-8 pb-4 border-b border-stone-200">
                    <h2 class="font-serif text-2xl font-medium text-stone-900">Related Stories</h2>
                    <a href="{{ route('articles.index') }}"
                       class="font-sans text-[0.65rem] tracking-[0.12em] uppercase text-stone-400 hover:text-stone-700 border-b border-stone-300 hover:border-stone-600 transition-colors pb-px">
                        View All
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($related as $rel)
                    <a href="{{ route('articles.show', $rel) }}" class="group block no-underline text-inherit">

                        @if($rel->thumbnail)
                        <div class="overflow-hidden aspect-video mb-4">
                            <img src="{{ asset('storage/' . $rel->thumbnail) }}"
                                 alt="{{ $rel->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        @endif

                        @if($rel->category)
                        <p class="font-sans text-[0.63rem] tracking-[0.12em] uppercase text-stone-400 mb-1">
                            {{ $rel->category->name }}
                        </p>
                        @endif

                        <h3 class="font-serif text-lg font-medium text-stone-900 leading-snug mb-2 group-hover:underline underline-offset-4">
                            {{ $rel->title }}
                        </h3>

                        <p class="font-sans text-sm text-stone-500 leading-relaxed line-clamp-2">
                            {{ Str::limit(strip_tags($rel->body), 90) }}
                        </p>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </div>

</x-app-layout>