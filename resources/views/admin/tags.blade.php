<x-admin-layout>

    <div class="mb-8">
        <h1 class="font-serif text-3xl font-medium text-stone-900">Tags</h1>
        <p class="text-sm text-stone-400 mt-1">Daftar semua tag beserta jumlah artikel yang menggunakannya.</p>
    </div>

    <section class="bg-white border border-stone-200 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-stone-100">
            <h2 class="font-serif text-lg font-medium text-stone-900">Semua Tag</h2>
        </div>

        {{-- Search --}}
        <div class="px-6 py-3 border-b border-stone-100 bg-stone-50">
            <form method="GET" action="{{ route('admin.tags') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari tag..."
                       class="flex-1 border border-stone-200 bg-white px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-stone-400">
                <button type="submit"
                        class="bg-stone-900 text-white px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-700 transition-colors">
                    Cari
                </button>
                @if(request('search'))
                <a href="{{ route('admin.tags') }}"
                   class="border border-stone-300 text-stone-500 px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-100 transition-colors">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100 bg-stone-50 text-left">
                    <th class="px-6 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Nama Tag</th>
                    <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Jumlah Artikel</th>
                    <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($tags as $tag)
                <tr class="hover:bg-stone-50 transition-colors">
                    <td class="px-6 py-3 font-medium text-stone-800">
                        <span class="inline-block text-[0.7rem] tracking-wider uppercase bg-stone-100 text-stone-600 px-2.5 py-1">
                            #{{ $tag->name }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-stone-400">{{ $tag->articles_count }} artikel</td>
                    <td class="px-4 py-3">
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="delete-btn text-[0.65rem] tracking-wider uppercase text-red-400 hover:text-red-700 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-stone-400 text-sm">
                        Tidak ada tag ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-stone-100">
            {{ $tags->links() }}
        </div>
    </section>

</x-admin-layout>