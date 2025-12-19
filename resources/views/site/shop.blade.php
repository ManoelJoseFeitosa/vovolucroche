<x-site-layout>
    {{-- Mensagem de Sucesso --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Cabeçalho --}}
    <div class="bg-teal-600 py-10 mb-10 mt-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl font-bold text-white">Nossa Loja</h1>
            <p class="text-teal-100 mt-2">Escolha seu modelo favorito e encomende agora.</p>
        </div>
    </div>

    {{-- Listagem de Produtos --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        
        @if($products->isEmpty())
            <div class="text-center py-20 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">Nenhum produto disponível no momento.</p>
                <p class="text-gray-400 text-sm mt-2">Volte em breve para ver novidades!</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 flex flex-col h-full hover:shadow-2xl transition-shadow duration-300">
                    
                    {{-- Imagem e Badges --}}
                    <div class="h-64 overflow-hidden bg-gray-50 relative group">
                        
                        {{-- 1. IMAGEM PRIMEIRO (Fica atrás) --}}
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 relative z-0">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-200">
                                <span class="text-sm">Imagem indisponível</span>
                            </div>
                        @endif
                        
                        {{-- 2. BOTÃO DE FAVORITAR (Vem depois, z-index 30) --}}
                        <div class="absolute top-2 right-2 z-30">
                            @auth
                                <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-white/90 backdrop-blur p-2 rounded-full shadow-sm hover:scale-110 transition duration-200 group/btn flex items-center justify-center">
                                        @if(Auth::user()->hasFavorited($product))
                                            {{-- Coração Preenchido --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-500">
                                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                            </svg>
                                        @else
                                            {{-- Coração Vazado --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 group-hover/btn:text-red-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="bg-white/90 backdrop-blur p-2 rounded-full shadow-sm hover:scale-110 transition duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </a>
                            @endauth
                        </div>

                        {{-- 3. ETIQUETA DE DIAS (Vem depois, z-index 30) --}}
                        <div class="absolute top-2 left-2 bg-white/90 backdrop-blur text-xs font-bold text-teal-700 px-3 py-1 rounded-full shadow-sm z-30">
                            ⏱ {{ $product->production_days }} dias para produzir
                        </div>

                    </div>

                    {{-- Conteúdo do Card --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h2 class="text-xl font-bold text-gray-800 mb-2 leading-tight">{{ $product->name }}</h2>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                        
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-400 text-xs uppercase font-semibold">Preço</span>
                                <span class="text-2xl font-bold text-teal-600">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('cart.add', $product->id) }}" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200 flex items-center justify-center gap-2 cursor-pointer text-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Adicionar ao Carrinho
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-site-layout>
