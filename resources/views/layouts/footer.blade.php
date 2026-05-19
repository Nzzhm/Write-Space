<footer class="border-t border- border-gray-700 mr-16 ml-16">
    <div class="mt-8 flex grid-cols-3 gap-6 mb-12">
        <div class="container mt-3">
            <h4 class="font-sans font-bold text-lg text-gray-800 tracking-tight">Write Space</h4>
           <p class="font-sans text-gray-600 leading-relaxed text-sm">
                    A digital space where ideas, knowledge, and inspiration come together through meaningful writing.
            </p>
           <p class="text-xs text-gray-400 font-mono tracking-wider pt-2">
                    &copy; {{ date('Y') }} Write Space & Team.
            </p>
        </div>
        <div class="container">
            <a href="{{ route('articles.index') }}">
                <img src="{{ asset('gambar/logo.png') }}" alt="" class="justify-center mx-auto h-32 w-auto hover:scale-110 transition-transform duration-300 ease-in-out">    
            </a>
        </div>
        <div class="container justify-center">
            <a href="#">
                <div class="mt-10 flex gap-4 justify-center ">
                    <img src="{{ asset('gambar/facebook.png') }}" alt="" class="h-8 w-auto hover:scale-110 transition-transform duration-300 ease-in-out">
                    <img src="{{ asset('gambar/instagram.png') }}" alt="" class="h-8 w-auto hover:scale-110 transition-transform duration-300 ease-in-out">
                    <img src="{{ asset('gambar/tiktok.png') }}" alt="" class="h-8 w-auto hover:scale-110 transition-transform duration-300 ease-in-out">
                    <img src="{{ asset('gambar/twitter.png') }}" alt="" class="h-8 w-auto hover:scale-110 transition-transform duration-300 ease-in-out">
                </div>
                <p class="text-center mt-4 text-gray-400 font-sans text-sm">Follow our social media</p>
            </a>
        </div>
    </div>
</footer>
