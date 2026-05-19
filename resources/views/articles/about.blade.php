<x-app-layout>

    {{-- ===== HEADER ===== --}}
    <div class="max-w-6xl mx-auto px-6 mt-4 mb-2">
        <div class="pt-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="font-serif font-bold text-5xl md:text-6xl text-black tracking-tight">
                    Write Space
                </h1>
                <p class="font-sans mt-2 text-sm md:text-base text-gray-500">
                    A space for reading, writing, and sharing inspiration.
                </p>
            </div>
            <div class="font-sans text-xs uppercase tracking-widest text-gray-700 font-medium">
                {{ now()->isoFormat('D MMMM YYYY') }}
            </div>
        </div>
    </div>

    {{-- ===== HERO TENTANG KAMI ===== --}}
    <section class="max-w-6xl mx-auto px-6 pt-16 mb-24">
        <div class="border-t border-black pt-8">
            <p class="text-xs tracking-widest uppercase text-gray-500 mb-4 font-sans">About Us</p>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-7">
                    <h2 class="font-serif text-6xl md:text-7xl font-bold tracking-tight text-black mb-8">
                        <span class="block mb-2">We Write.</span>
                        <span class="block mb-2">We Read.</span>
                        <span class="block">We Share.</span>
                    </h2>
                    <div class="w-16 h-px bg-black mb-8"></div>
                    <p class="font-sans text-lg text-gray-600 leading-relaxed mb-6">
                        Write Space lahir dari keyakinan sederhana: bahwa kata-kata memiliki kekuatan untuk mengubah cara kita memandang dunia. Kami adalah ruang bagi para pemikir, penulis, dan pembaca yang percaya bahwa narasi yang baik layak untuk dibagikan.
                    </p>
                    <p class="font-sans text-lg text-gray-600 leading-relaxed">
                        Didirikan sebagai platform editorial independen, Write Space menjadi rumah bagi tulisan-tulisan yang melampaui berita, menyentuh budaya, arsitektur, seni, dan kehidupan sehari-hari dengan perspektif yang segar dan jujur.
                    </p>
                </div>
                <div class="lg:col-span-5">
                    <div class="bg-gray-50 border border-gray-200 p-10">
                        <p class="font-serif text-2xl italic text-gray-800 leading-snug mb-4 p-6">
                            "Menulis adalah cara kita merekam keberadaan kita di dunia ini."
                        </p>
                        <p class="text-xs tracking-widest uppercase text-gray-500 font-sans mb-4 ml-10">
                            — Tim Write Space
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== MISI & NILAI ===== --}}
    <section class="max-w-6xl mx-auto px-6 mb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 border-t pt-8 border-gray-400">

            <div class="p-10 ">
                <span class="font-serif text-5xl text-gray-200 font-bold block mb-6">01</span>
                <h3 class="font-serif text-2xl font-semibold mb-4">Misi Kami</h3>
                <p class="font-sans text-sm text-gray-500 leading-relaxed">
                    Menghadirkan konten editorial berkualitas tinggi yang memantik pikiran, menginspirasi tindakan, dan merayakan keindahan dalam tulisan dari berbagai sudut pandang.
                </p>
            </div>

            <div class="p-10">
                <span class="font-serif text-5xl text-gray-200 font-bold block mb-6">02</span>
                <h3 class="font-serif text-2xl font-semibold mb-4">Visi Kami</h3>
                <p class="font-sans text-sm text-gray-500 leading-relaxed">
                    Menjadi platform editorial terpercaya yang menjembatani penulis independen dengan pembaca yang haus akan cerita autentik — lokal, namun bervisi global.
                </p>
            </div>

            <div class="p-10">
                <span class="font-serif text-5xl text-gray-200 font-bold block mb-6">03</span>
                <h3 class="font-serif text-2xl font-semibold mb-4">Nilai Kami</h3>
                <p class="font-sans text-sm text-gray-500 leading-relaxed">
                    Kejujuran, kedalaman, dan keindahan. Kami percaya bahwa tulisan yang baik tidak hanya menyampaikan informasi, tetapi juga menciptakan pengalaman yang membekas.
                </p>
            </div>

        </div>
    </section>

    {{-- ===== BERGABUNG DENGAN KAMI ===== --}}
    <section class="max-w-6xl mx-auto px-6 mb-3">
        <div class="bg-black text-white py-10 px-10 md:px-16 flex flex-col md:flex-row items-center justify-between gap-8">
            <div >
                <p class="text-xs tracking-widest uppercase text-gray-400 mb-3 font-sans">Open Call</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold leading-tight mb-4">
                    Punya cerita<br>untuk dibagikan?
                </h2>
                <p class="font-sans text-gray-400 text-base max-w-md">
                    Write Space selalu membuka pintu bagi penulis baru. Kirimkan tulisanmu dan jadilah bagian dari komunitas kami.
                </p>
            </div>
            <div class="shrink-0 mr-6">
                <a href="{{ route('login') }}"
                   class="block border border-white text-white text-xs tracking-widest uppercase px-8 py-4 hover:bg-white hover:text-black transition duration-300">
                    Mulai Menulis
                </a>
            </div>
        </div>
    </section>

</x-app-layout>