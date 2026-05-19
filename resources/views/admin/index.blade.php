<x-admin-layout>

    <div class="mb-8">
        <h1 class="font-serif text-3xl font-medium text-stone-900">Dashboard</h1>
        <p class="text-sm text-stone-400 mt-1">Kelola artikel, kategori, dan pengaturan situs.</p>
    </div>

    <div class="space-y-10">

        {{-- ===== ARTIKEL ===== --}}
        <section class="bg-white border border-stone-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-stone-100 flex items-center justify-between">
                <h2 class="font-serif text-lg font-medium text-stone-900">Artikel</h2>
                <a href="{{ route('articles.create') }}"
                   class="text-[0.7rem] tracking-widest uppercase text-white bg-stone-900 px-4 py-2 hover:bg-stone-700 transition-colors">
                    + Tulis Artikel
                </a>
            </div>

            <div class="px-6 py-3 border-b border-stone-100 bg-stone-50">
                <form method="GET" action="{{ route('admin.index') }}" class="flex gap-2">
                    {{-- Pertahankan search_category kalau ada --}}
                    @if(request('search_category'))
                        <input type="hidden" name="search_category" value="{{ request('search_category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul artikel..."
                           class="flex-1 border border-stone-200 bg-white px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-stone-400">
                    <button type="submit"
                            class="bg-stone-900 text-white px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-700 transition-colors">
                        Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.index') }}"
                       class="border border-stone-300 text-stone-500 px-4 py-1.5 text-[0.7rem] tracking-widest uppercase hover:bg-stone-100 transition-colors">
                        Reset
                    </a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-stone-100 text-left bg-stone-50">
                            <th class="px-6 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Judul</th>
                            <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Penulis</th>
                            <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Kategori</th>
                            <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Hero</th>
                            <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">EC</th>
                            <th class="px-4 py-3 text-[0.65rem] tracking-widest uppercase text-stone-400 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($articles as $article)
                        <tr class="hover:bg-stone-50 transition-colors">
                            <td class="px-6 py-3 font-medium text-stone-800">
                                <a href="{{ route('articles.show', $article) }}" target="_blank"
                                   class="hover:underline underline-offset-2">
                                    {{ Str::limit($article->title, 45) }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-stone-400">{{ $article->user->name }}</td>
                            <td class="px-4 py-3 text-stone-400">{{ $article->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.hero') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <button type="submit"
                                            class="text-[0.65rem] tracking-wider uppercase px-2.5 py-1 transition-colors
                                                   {{ $article->is_hero ? 'bg-stone-900 text-white' : 'border border-stone-300 text-stone-400 hover:border-stone-900 hover:text-stone-900' }}">
                                        {{ $article->is_hero ? '★ Hero' : 'Set' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.editorsChoice', $article) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="is_editors_choice" value="{{ $article->is_editors_choice ? '0' : '1' }}">
                                    <button type="submit"
                                            class="text-[0.65rem] tracking-wider uppercase px-2.5 py-1 transition-colors
                                                   {{ $article->is_editors_choice ? 'bg-stone-900 text-white' : 'border border-stone-300 text-stone-400 hover:border-stone-900 hover:text-stone-900' }}">
                                        {{ $article->is_editors_choice ? '★ EC' : 'Set' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="delete-btn text-[0.65rem] tracking-wider uppercase text-red-400 hover:text-red-700 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-stone-400 text-sm">
                                Tidak ada artikel ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-stone-100">
                {{ $articles->links() }}
            </div>
        </section>


        {{-- ===== KATEGORI ===== --}}
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
                <form method="GET" action="{{ route('admin.index') }}" class="flex gap-2">
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
                    <a href="{{ route('admin.index') }}"
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
                            <a href="{{ route('admin.index') }}"
                               class="text-[0.65rem] tracking-wider uppercase text-stone-400 hover:text-stone-700 transition-colors">
                                Batal
                            </a>
                            @else
                            <a href="{{ route('admin.index') }}?edit={{ $category->id }}"
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


        {{-- ===== QUOTE ===== --}}
        <section class="bg-white border border-stone-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-stone-100">
                <h2 class="font-serif text-lg font-medium text-stone-900">Quote Halaman Utama</h2>
                <p class="text-xs text-stone-400 mt-0.5">Tampil sebagai kutipan editorial di halaman beranda.</p>
            </div>

            <form action="{{ route('admin.quote') }}" method="POST" class="px-6 py-6 space-y-4">
                @csrf

                @if($quoteText)
                <div class="border-l-2 border-stone-900 pl-5 py-1">
                    <p class="font-serif text-base italic text-stone-600">"{{ $quoteText }}"</p>
                    <p class="text-[0.65rem] tracking-[0.12em] uppercase text-stone-400 mt-1">{{ $quoteAuthor }}</p>
                </div>
                @endif

                <div>
                    <label class="block text-[0.65rem] tracking-widest uppercase text-stone-400 mb-1.5">Teks Quote</label>
                    <textarea name="quote_text" rows="3"
                              class="w-full border border-stone-200 px-3 py-2 text-sm font-serif text-stone-800 focus:outline-none focus:ring-1 focus:ring-stone-400 resize-none"
                              placeholder="Masukkan kutipan...">{{ $quoteText }}</textarea>
                </div>

                <div>
                    <label class="block text-[0.65rem] tracking-widest uppercase text-stone-400 mb-1.5">Atribusi / Penulis</label>
                    <input type="text" name="quote_author" value="{{ $quoteAuthor }}"
                           placeholder="— Nama Penulis"
                           class="w-full border border-stone-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-stone-400">
                </div>

                <button type="submit"
                        class="bg-stone-900 text-white text-[0.7rem] tracking-widest uppercase px-6 py-2.5 hover:bg-stone-700 transition-colors">
                    Simpan Quote
                </button>
            </form>
        </section>

    </div>

    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                if (confirm('Yakin ingin menghapus ini?')) {
                    btn.closest('form').submit();
                }
            });
        });
    </script>

</x-admin-layout>