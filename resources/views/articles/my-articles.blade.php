<x-app-layout>
    <div class="container mx-auto px-6 sm:px-6 lg:px-8">

    
    <section class="py-8 my-4 px-6 rounded-xl bg-white shadow-lg">
            <h3 class="font-serif text-2xl font-semibold mb-4 border-b pb-2">Semua Artikel</h3>

            {{-- Tombol Tambah Artikel --}}
            <button type="button" class="border px-5 py-3 mb-4 tracking-widest uppercase text-sm rounded-lg bg-black text-white hover:bg-gray-800">
                <a href="{{ route('articles.create') }}">Tambah Artikel</a>
            </button>

            {{-- Search --}}
            <form method="GET" action="{{ route('articles.my') }}" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul artikel..."
                       class="border px-3 py-2 w-full">
                <button type="submit"
                        class="bg-black text-white px-4 py-2 text-sm tracking-widest uppercase hover:bg-gray-800">
                    Cari
                </button>
            </form>

            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="border-b text-left">
                        <th class="w-1/5 py-3 pr-4">Thumbnail</th>
                        <th class="w-1/5 py-3 pr-4">Judul</th>
                        <th class="w-1/5 py-3 pr-4">Penulis</th>
                        <th class="w-1/5 py-3 pr-4">Kategori</th>
                        <th class="w-1/5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr class="border-b hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('articles.show', $article) }}'">
                        <td><img src="{{ asset('storage/'. $article->thumbnail) }}" alt="thumbnail" class="w-28 h-28 object-cover rounded"></td>
                        <td class="py-3 pr-4 font-medium">
                            <a href="{{ route('articles.show', $article) }}"
                               class="hover:underline" target="_blank">
                                {{ Str::limit($article->title, 40) }}
                            </a>
                        </td>
                        <td class="py-3 pr-4 text-gray-500">{{ $article->user->name }}</td>
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
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

                    @endforeach
                </tbody>

                </div>
</x-app-layout>