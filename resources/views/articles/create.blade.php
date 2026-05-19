<x-app-layout>
    @push('styles')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            .ql-toolbar { border-top: none !important; border-left: none !important; border-right: none !important; }
            .ql-container { border: none !important; font-size: 16px; }
            #quill-editor { min-height: 500px; }
        </style>
    @endpush

    <div class="min-h-screen bg-gray-50">

        {{-- ===== TOP BAR ===== --}}
        <div class="border-b bg-white px-6 py-4 flex items-center justify-between sticky top-0 z-10">
            <h1 class="font-serif text-xl font-semibold">Create New Article</h1>
            <div class="flex gap-3">
                <button form="article-form" type="submit" name="status" value="draft"
                        class="border border-black px-5 py-2 text-sm hover:bg-gray-100 transition">
                    Save Draft
                </button>
                <button form="article-form" type="submit" name="status" value="published"
                        class="bg-black text-white px-5 py-2 text-sm hover:bg-gray-800 transition">
                    Publish
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('articles.store') }}" 
              id="article-form" enctype="multipart/form-data">
            @csrf

            <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ===== KOLOM KIRI: EDITOR ===== --}}
                <div class="md:col-span-2 bg-white border">

                    {{-- Judul --}}
                    <div class="border-b px-8 py-6">
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="Enter headline..."
                               class="w-full text-4xl font-serif font-medium placeholder-gray-300 outline-none border-none bg-transparent">
                        @error('title')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Quill Editor --}}
                    <div class="px-8 py-6">
                        <div id="quill-editor"></div>
                        <input type="hidden" name="body" id="body">
                        @error('body')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ===== KOLOM KANAN: SIDEBAR ===== --}}
                <div class="space-y-6">

                    {{-- Ganti bagian Featured Image --}}
                    <div class="bg-white border p-5">
                        <h3 class="text-xs tracking-widest uppercase font-bold mb-3">Featured Image</h3>
                        
                        {{-- Preview --}}
                        <div id="image-preview" class="{{ old('title') && old('_thumbnail_exists') ? '' : 'hidden' }} mb-3">
                            <img id="preview-img" src="" class="w-full aspect-video object-cover">
                            <button type="button" onclick="removeImage()"
                                    class="text-xs text-red-500 mt-1 hover:underline">
                                Hapus gambar
                            </button>
                        </div>

                        {{-- Drop zone --}}
                        <div id="drop-zone"
                            class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 p-8 cursor-pointer hover:border-black transition aspect-video">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-gray-400">Drag & drop or <span class="font-semibold text-black">Browse</span></span>
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden">
                        </div>

                        @error('thumbnail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="bg-white border p-5">
                        <h3 class="text-xs tracking-widest uppercase font-bold mb-3">Category</h3>
                        <select name="category_id" class="w-full border px-3 py-2 text-sm bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div class="bg-white border p-5">
                        <h3 class="text-xs tracking-widest uppercase font-bold mb-3">Tags</h3>
                        
                        {{-- Badge container --}}
                        <div id="tag-badges" class="flex flex-wrap gap-2 mb-3"></div>

                        {{-- Input --}}
                        <input type="text" id="tag-input"
                               placeholder="Ketik tag, tekan Enter..."
                               class="w-full border px-3 py-2 text-sm">
                        
                        {{-- Hidden input untuk dikirim ke controller --}}
                        <input type="hidden" name="tags_input" id="tags-hidden">

                        {{-- Suggestions dari tag yang sudah ada --}}
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($tags as $tag)
                                <button type="button"
                                        onclick="addTag('{{ $tag->name }}')"
                                        class="text-xs border px-2 py-1 hover:bg-black hover:text-white transition">
                                    + {{ $tag->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        // Quill
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Tulis artikel kamu di sini...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'header': [1, 2, 3, false] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        document.getElementById('article-form').addEventListener('submit', function() {
            document.getElementById('body').value = quill.root.innerHTML;
            // Debug — lihat isi tags sebelum submit
            console.log('tags_input:', document.getElementById('tags-hidden').value);
        });

        // Restore konten Quill saat error validasi
        const oldBody = `{!! old('body') !!}`;
        if (oldBody) {
            quill.root.innerHTML = oldBody;
        }
        
        // ===== DROPZONE =====
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('thumbnail');
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');

        // Klik drop zone → buka file picker
        dropZone.addEventListener('click', () => fileInput.click());

        // Drag over — cegah default browser (buka file)
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-black');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-black');
        });

        // Drop file
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-black');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                // Masukkan file ke input
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                showPreview(file);
            }
        });

        // Pilih file via click
        fileInput.addEventListener('change', function() {
            if (this.files[0]) showPreview(this.files[0]);
        });

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
                dropZone.classList.add('hidden'); // sembunyikan dropzone
            };
            reader.readAsDataURL(file);
        }

        function removeImage() {
            fileInput.value = '';
            previewImg.src = '';
            preview.classList.add('hidden');
            dropZone.classList.remove('hidden'); // tampilkan dropzone lagi
        }

        // ===== TAGS =====
        let tags = [];

        // Restore tags saat error validasi
        const oldTags = `{{ old('tags_input') }}`;
        if (oldTags) {
            oldTags.split(',').forEach(t => addTag(t));
        }

        function addTag(name) {
            name = name.trim();
            if (!name || tags.includes(name)) return;
            tags.push(name);
            renderTags();
        }

        function removeTag(name) {
            tags = tags.filter(t => t !== name);
            renderTags();
        }

        function renderTags() {
            const container = document.getElementById('tag-badges');
            container.innerHTML = tags.map(tag => `
                <span class="flex items-center gap-1 bg-black text-white text-xs px-2 py-1">
                    ${tag}
                    <button type="button" onclick="removeTag('${tag}')" class="ml-1 hover:text-gray-300">×</button>
                </span>
            `).join('');
            document.getElementById('tags-hidden').value = tags.join(',');
        }

        document.getElementById('tag-input').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTag(this.value);
                this.value = '';
            }
        });
    </script>
    @endpush
</x-app-layout>