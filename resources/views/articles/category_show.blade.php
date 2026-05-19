<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold font-sans text-xl text-gray-800 leading-tight">
            Category: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-between"> 
                <form action="{{ route('categories.show', $category->slug) }}" method="GET">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search spesific article . . ." class=" border px-3 py-2 text-sm w-80">
                    <button type="submit" class="uppercase tracking-wider border px-3 py-2 text-sm bg-black text-white hover:border-black hover:bg-white hover:text-black transition">
                        Search</button>
                </form>
                <div class="text-white hover:text-black hover:bg-white border border-black hover:translate-x-1 transition-all duration-300 w-60 text-sm tracking-wider font-sans bg-black px-3 py-2 content-end uppercase">
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('articles.index') }}{{ url()->previous() }}" >
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to previous page
                        </a>
                </div>
            </div>
            @if ($articles->count())
                <div class="grid gap-8 grid-cols-1 md:grid-cols-2">
            @foreach ($articles as $article)
            <a href="{{ route('articles.show', $article) }}" class="group flex flex-col h-full border border-neutral-200 bg-white hover:border-black transition-colors duration-300">
                <div class="p-8 md:p-10 flex flex-col h-full justify-between">
                    
                    <div>
                        <!-- Metadata Atas -->
                        <div class="flex items-center justify-between text-xs tracking-widest text-neutral-400 uppercase font-medium">
                            <span>{{ $article->created_at->diffForHumans() }}</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-300 group-hover:bg-black transition-colors duration-300"></span>
                        </div>

                        <!-- Judul Artikel -->
                        <h3 class="text-2xl font-light text-neutral-900 mt-6 tracking-tight leading-snug line-clamp-2 group-hover:text-black transition-colors duration-200 font-serif">
                            {{ $article->title }}
                        </h3>
                        
                        <!-- Ringkasan Konten -->
                        <p class="text-neutral-500 text-sm mt-4 line-clamp-3 leading-relaxed font-sans font-light">
                            {{ strip_tags($article->body) }}
                        </p>
                    </div>

                    <!-- Bagian Bawah: Penulis & Tanda Panah -->
                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-neutral-100">
                        <div class="text-xs tracking-wider">
                            <span class="text-neutral-400 block font-light">Writen by</span>
                            <span class="font-medium text-neutral-800 uppercase text-[11px]">{{ $article->user->name }}</span>
                        </div>
                        <div class="text-neutral-400 group-hover:text-black group-hover:translate-x-1 transition-all duration-300">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </div>

                </div>
            </a>
            @endforeach
        </div>
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
                
            @else
                <p class="text-gray-500">Belum ada artikel di kategori ini.</p>
            @endif

        </div>
    </div>
</x-app-layout>