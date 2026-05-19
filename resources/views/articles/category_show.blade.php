<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategori: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($articles->count())
                <div class="grid gap-6">
                    @foreach ($articles as $article)
                    <a href="{{ route('articles.show', $article) }}" class="block">
                        <div class="bg-white p-6 rounded shadow hover:bg-gray-50">
                            <h3 class="text-lg font-semibold">
                                
                                    {{ $article->title }}
                                
                            </h3>
                            <p class="text-gray-500 text-sm mt-1">
                                Oleh {{ $article->user->name }} ·
                                {{ $article->created_at->diffForHumans() }}
                            </p>
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

            <a href="{{ route('articles.index') }}" class="mt-6 inline-block text-blue-500 hover:underline">
                ← Kembali
            </a>
        </div>
    </div>
</x-app-layout>