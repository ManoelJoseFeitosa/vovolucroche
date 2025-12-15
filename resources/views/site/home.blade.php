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
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 overflow-hidden group flex flex-col">
                    <div class="h-72 overflow-hidden bg-gray-100 flex items-center justify-center relative">
                         @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                         @else
                            <div class="text-gray-400 flex flex-col items-center">
                                <span class="text-4xl mb-2">🧶</span>
                                <span>Sem Imagem</span>
                            </div>
                         @endif
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
