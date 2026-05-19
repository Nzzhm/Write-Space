<x-app-layout>
    <div class="container mx-auto px-6 sm:px-6 lg:px-8">

    
    <section class="py-8 my-4 px-6 rounded-xl bg-white shadow-lg mb-11">
            <div class="mb-5 border-b">
                    <h3 class="font-serif text-3xl font-bold tracking-tight text-neutral-900">My Articles</h3>
                    <p class="text-xs text-neutral-400 tracking-wider uppercase mt-1 mb-5">All your articles are here</p>
                </div>

            {{-- Tombol Tambah Artikel --}}
            <button type="button" class="border px-5 py-3 mb-4 tracking-widest uppercase text-sm  bg-black text-white hover:bg-white hover:text-black border-black hover:translate-x-2 ease-in-out duration-300">
                <a href="{{ route('articles.create') }}">Tambah Artikel</a>
            </button>

            {{-- Search --}}
            <form method="GET" action="{{ route('articles.my') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul artikel..."
                       class="border px-3 py-2 w-full">
                <button type="submit"
                        class="px-4 py-2 text-sm tracking-widest uppercase bg-black text-white hover:bg-white hover:text-black border-black border">
                    Cari
                </button>
            </form>

            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="border-b text-left">
                        <th class="w-1/4 py-3 pr-4">Thumbnail</th>
                        <th class="w-1/3 py-3 pr-4">Judul</th>
                        <th class="w-1/4 py-3 pr-4">Kategori</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse ($articles as $article)
                        <tr class="group hover:bg-neutral-50 transition-colors duration-200 cursor-pointer" onclick="window.location='{{ route('articles.show', $article) }}'">
                        <td class="py-5 pr-4 vertical-align-middle">
                            <div class="w-20 h-20 bg-neutral-100 overflow-hidden border border-neutral-200">
                                <img src="{{ asset('storage/'. $article->thumbnail) }}" alt="thumbnail" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110">
                            </div>
                        </td>
                        <td class="py-5 pr-4">
                            <a href="{{ route('articles.show', $article) }}" class="font-serif text-lg font-normal text-neutral-800 group-hover:text-black block leading-snug tracking-tight" onclick="event.stopPropagation()">
                                {{ Str::limit($article->title, 55) }}
                            </a>
                            <span class="text-xs text-neutral-400 font-light block mt-1">
                                Oleh <span class="font-medium text-neutral-600 uppercase text-[10px] tracking-wider">{{ $article->user->name }}</span>
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-gray-500">{{ $article->category?->name ?? '-' }}</td>
                        <td class="py-3">
                            <div class="flex gap-2 " onclick="event.stopPropagation()">
                                <a href="{{ route('articles.edit', $article) }}" class="px-3 py-1 border border-black text-xs uppercase hover:bg-black hover:text-white transition">
                                    Edit
                                </a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="px-3 py-1 border border-red-500 text-red-500 text-xs uppercase hover:bg-red-500 hover:text-white transition delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-neutral-400">
                                <p class="text-lg font-sans">You haven't written any articles yet</p>
                                <a href="{{ route('articles.create') }}" class="text-sm uppercase tracking-widest underline mt-2 inline-block hover:text-black">
                                    Write your article now
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </section>
</div>

</x-app-layout>