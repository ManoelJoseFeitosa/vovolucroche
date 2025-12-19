<x-site-layout>
    <div class="bg-gradient-to-b from-teal-50 to-white py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 flex flex-col md:flex-row items-center gap-12">
            
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 leading-tight mb-6">
                    Arte feita à mão com <br>
                    <span class="text-teal-500">amor e carinho</span>
                </h1>
                <p class="text-gray-600 text-lg mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                    Peças exclusivas de crochê para decorar seu lar ou presentear quem você ama. 
                    Personalização e qualidade em cada ponto.
                </p>
                
                <a href="{{ route('shop') }}" class="inline-block bg-teal-500 text-white font-bold text-lg py-4 px-10 rounded-lg shadow-md hover:bg-teal-600 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    Ver Loja
                </a>
            </div>

            <div class="md:w-1/2 flex justify-center">
                <div class="w-80 h-80 md:w-[450px] md:h-[450px] bg-white rounded-full shadow-2xl flex items-center justify-center p-10 border-4 border-teal-50">
                   <img src="{{ asset('images/logovovolu.jpeg') }}" class="w-full h-full object-contain">
                </div>
            </div>
        </div>
    </div>

    <div class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 relative inline-block">
                    A História do Crochê
                    <span class="block h-1.5 w-24 bg-teal-500 mx-auto mt-4 rounded-full"></span>
                </h2>
            </div>
            
            <div class="text-gray-700 text-lg leading-8 text-justify space-y-6 font-light">
                <p>
                    O crochê é uma arte milenar que atravessa gerações. Na <strong>Vovó Lu Crochê</strong>, 
                    cada peça carrega uma história única de dedicação e paciência. Não é apenas fio entrelaçado; 
                    é tempo, é pensamento e é energia positiva colocada em cada laçada.
                </p>
                <p>
                    Tudo começou como um passatempo para acalmar a mente e criar presentes significativos para a família. 
                    Com o tempo, o amor pelos fios e agulhas transformou-se em um desejo ardente de levar essa 
                    beleza e aconchego para mais lares. Nossas peças fogem do industrial; elas trazem a imperfeição 
                    perfeita do trabalho manual, o carinho e a atenção aos detalhes que nenhuma máquina pode replicar.
                </p>
            </div>
        </div>
    </div>

    @if($featuredProducts->count() > 0)
    <div class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800">Alguns Trabalhos Realizados</h2>
                <p class="text-gray-500 mt-3 text-lg">Um pouco do que já criamos para nossos clientes</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden group flex flex-col relative">
                    
                    {{-- ÁREA DA IMAGEM --}}
                    <div class="h-72 overflow-hidden bg-gray-100 flex items-center justify-center relative">
                         
                         {{-- 1. IMAGEM (Agora vem primeiro no código para ficar atrás) --}}
                         @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110 relative z-0">
                         @else
                            <div class="text-gray-400 flex flex-col items-center">
                                <span class="text-4xl mb-2">🧶</span>
                                <span>Sem Imagem</span>
                            </div>
                         @endif

                         {{-- 2. BOTÃO DE FAVORITAR (Agora vem depois no código para ficar na frente - z-30) --}}
                         <div class="absolute top-3 right-3 z-30">
                            @auth
                                <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-white p-2 rounded-full shadow hover:scale-110 transition duration-200 group/btn">
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
                                <a href="{{ route('login') }}" class="bg-white p-2 rounded-full shadow hover:scale-110 transition duration-200 block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="p-8 text-center flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                            <p class="text-2xl text-teal-600 font-bold mb-6">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('shop') }}" class="block w-full py-3 border-2 border-teal-500 text-teal-600 font-bold rounded-lg hover:bg-teal-500 hover:text-white transition duration-300">
                            VER DETALHES
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</x-site-layout>