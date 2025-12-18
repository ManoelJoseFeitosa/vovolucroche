<x-site-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Olá, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-gray-500">Acompanhe seus pedidos e histórico de compras.</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Sair da conta
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="mb-12">
                <h2 class="text-xl font-bold text-teal-700 mb-4 flex items-center gap-2">
                    <span class="bg-teal-100 p-1 rounded">📦</span> Pedidos em Andamento
                </h2>

                @if($activeOrders->isEmpty())
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center text-gray-500 border border-dashed border-gray-300">
                        Você não tem pedidos em aberto no momento.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($activeOrders as $order)
                            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-teal-500 relative">
                                <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                                    <div>
                                        <span class="text-xs font-bold text-gray-400 uppercase">Pedido #{{ $order->id }}</span>
                                        <p class="text-gray-600 text-sm">{{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
                                        <p class="font-bold text-lg text-gray-800 mt-1">R$ {{ number_format($order->total_price, 2, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="mt-4 md:mt-0 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status == 'paid' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status == 'confeccao' ? 'bg-pink-100 text-pink-800' : '' }}
                                            {{ $order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}">
                                            
                                            @if($order->status == 'pending') 🕒 Aguardando Pagamento
                                            @elseif($order->status == 'paid') 🧶 Em Confecção
                                            @elseif($order->status == 'confeccao') 🧶 Em Confecção
                                            @elseif($order->status == 'shipped') 🚚 Enviado / Em Trânsito
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="border-t pt-3 mb-4">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-bold">Itens:</span> 
                                        @foreach($order->items as $item)
                                            {{ $item->quantity }}x {{ $item->product_name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </p>
                                </div>

                                @if($order->status == 'shipped')
                                    <div class="bg-purple-50 p-4 rounded-lg flex flex-col md:flex-row items-center justify-between gap-4">
                                        <div class="text-purple-800 text-sm">
                                            <p class="font-bold">Seu pedido já chegou?</p>
                                            <p>Confirme o recebimento para liberar sua garantia e avaliar.</p>
                                        </div>
                                        <form action="{{ route('customer.order.received', $order->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700 transition font-bold text-sm">
                                                ✅ JÁ RECEBI O PRODUTO
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <hr class="border-gray-300 my-10">

            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-6 flex items-center gap-2">
                    <span class="bg-gray-200 p-1 rounded">📜</span> Histórico de Pedidos
                </h2>

                @if($pastOrders->isEmpty())
                    <p class="text-gray-500">Nenhum pedido anterior encontrado.</p>
                @else
                    @foreach($pastOrders as $order)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8 overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-gray-700">Pedido #{{ $order->id }}</span>
                                    <span class="text-green-600 text-sm font-bold ml-2">● Concluído em {{ $order->updated_at->format('d/m/Y') }}</span>
                                </div>
                                <form action="{{ route('customer.buyAgain', $order->id) }}" method="POST">
                                    @csrf
                                    <button class="text-teal-600 hover:text-teal-800 font-bold text-sm flex items-center gap-1 hover:underline">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Comprar Novamente
                                    </button>
                                </form>
                            </div>

                            <div class="p-6 bg-white">
                                <h3 class="text-sm font-bold text-gray-500 mb-4 uppercase">Avalie seus produtos:</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($order->items as $item)
                                        <div class="border rounded-lg p-4 flex flex-col gap-3">
                                            <p class="font-bold text-gray-800 text-lg">{{ $item->product_name }}</p>
                                            
                                            {{-- Verifica se já avaliou --}}
                                            @php $review = $item->product->reviews->first(); @endphp

                                            @if($review)
                                                <div class="bg-yellow-50 p-3 rounded border border-yellow-100">
                                                    <div class="flex text-yellow-400 mb-1">
                                                        @for($i=0; $i < 5; $i++)
                                                            <svg class="w-5 h-5 {{ $i < $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                        @endfor
                                                    </div>
                                                    <p class="text-gray-600 text-sm italic">"{{ $review->comment ?? 'Sem comentário' }}"</p>
                                                </div>
                                            @else
                                                <form action="{{ route('customer.review') }}" method="POST" class="mt-auto">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    
                                                    <div class="mb-2">
                                                        <label class="text-xs text-gray-500">Nota:</label>
                                                        <div class="flex gap-2 mt-1">
                                                            @for($i=1; $i<=5; $i++)
                                                                <label class="cursor-pointer">
                                                                    <input type="radio" name="rating" value="{{ $i }}" class="peer hidden" required>
                                                                    <svg class="w-6 h-6 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                                </label>
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    <textarea name="comment" rows="2" class="w-full text-sm border-gray-300 rounded mb-2" placeholder="O que achou do produto?"></textarea>
                                                    
                                                    <button type="submit" class="w-full bg-teal-50 text-teal-700 border border-teal-200 hover:bg-teal-100 px-3 py-2 rounded text-sm font-bold transition">
                                                        Enviar Avaliação
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-site-layout>
