<x-site-layout>
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-teal-600 py-10 mb-10 mt-6"> <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl font-bold text-white">Nossa Loja</h1>
            <p class="text-teal-100 mt-2">Escolha seu modelo favorito e encomende agora.</p>
        </div>
    </div>

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
                    
                    <div class="h-64 overflow-hidden bg-gray-50 relative group">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-200">
                                <span class="text-sm">Imagem indisponível</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-bold text-teal-700 px-3 py-1 rounded-full shadow-sm">
                            ⏱ {{ $product->production_days }} dias para produzir
                        </div>
                    </div>

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
