<x-admin-layout>

    <div class="mb-8">
        <h1 class="font-serif text-3xl font-medium text-stone-900">Categories</h1>
        <p class="text-sm text-stone-400 mt-1">Kelola kategori artikel disini</p>
    </div>

    <div class="space-y-10">

        <section class="bg-white border border-stone-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-stone-100">
                <h2 class="font-serif text-lg font-medium text-stone-900">Kategori</h2>
            </div>

            {{-- Tambah kategori --}}
            <div class="px-6 py-4 border-b border-stone-100 bg-stone-50">
                <form action="{{ route('admin.create.categories') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Nama kategori baru..."
                           class="flex-1 border border-stone-200 bg-white px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-stone-400">
                    <button type="submit"
                            class="bg-stone-900 text-white px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-700 transition-colors">
                        Tambah
                    </button>
                </form>
            </div>

            {{-- Search kategori --}}
            <div class="px-6 py-3 border-b border-stone-100">
                <form method="GET" action="{{ route('admin.categories') }}" class="flex gap-2">
                    {{-- Pertahankan search artikel kalau ada --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <input type="text" name="search_category" value="{{ request('search_category') }}"
                           placeholder="Cari kategori..."
                           class="flex-1 border border-stone-200 bg-white px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-stone-400">
                    <button type="submit"
                            class="bg-stone-900 text-white px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-700 transition-colors">
                        Cari
                    </button>
                    @if(request('search_category'))
                    <a href="{{ route('admin.categories') }}"
                       class="border border-stone-300 text-stone-500 px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-100 transition-colors">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-100 bg-stone-50 text-left">
                        <th class="px-6 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium w-1/2">Nama</th>
                        <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium w-1/3">Slug</th>
                        <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($categories as $category)
                    @php $editing = (string)$editingId === (string)$category->id; @endphp
                    <tr class="hover:bg-stone-50 transition-colors">
                        <td class="px-6 py-3 font-medium text-stone-800">
                            @if ($editing)
                            <form id="edit-form-{{ $category->id }}"
                                  method="POST"
                                  action="{{ route('admin.update.category', $category) }}">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="name" value="{{ $category->name }}" autofocus
                                       class="border border-stone-300 px-2 py-1 text-sm w-full focus:outline-none focus:ring-1 focus:ring-stone-700">
                            </form>
                            @else
                            {{ $category->name }}
                            @endif
                        </td>
                        <td class="px-4 py-3 text-stone-400">
                            @if ($editing)
                            <span class="text-xs text-stone-300 italic">Otomatis dari nama</span>
                            @else
                            {{ $category->slug }}
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-3 items-center">
                            @if ($editing)
                            <button type="submit" form="edit-form-{{ $category->id }}"
                                    class="text-[0.65rem] tracking-wider uppercase text-white bg-stone-900 px-3 py-1 hover:bg-stone-700 transition-colors">
                                Simpan
                            </button>
                            <a href="{{ route('admin.categories', array_filter(request()->query(), fn($k) => $k !== 'edit', ARRAY_FILTER_USE_KEY)) }}">
                                    Batal
                                </a>
                            @else
                            <a href="{{ route('admin.categories', array_merge(request()->query(), ['edit' => $category->id])) }}"
                               class="text-[0.65rem] tracking-wider uppercase text-stone-500 hover:text-stone-900 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.destroy.category', $category) }}"
                                  method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="delete-btn text-[0.65rem] tracking-wider uppercase text-red-400 hover:text-red-700 transition-colors">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-stone-400 text-sm">
                            Tidak ada kategori ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-stone-100">
                {{ $categories->links() }}
            </div>
        </section>
    </div>
</x-admin-layout>