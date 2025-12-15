<x-site-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Seu Carrinho de Compras</h1>

            @if(session('cart') && count(session('cart')) > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <table class="w-full text-left">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                                    <tr>
                                        <th class="p-4">Produto</th>
                                        <th class="p-4 text-center">Qtd</th>
                                        <th class="p-4 text-right">Preço</th>
                                        <th class="p-4 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @php $subtotal = 0; @endphp
                                    @foreach(session('cart') as $id => $details)
                                        @php $subtotal += $details['price'] * $details['quantity']; @endphp
                                        <tr>
                                            <td class="p-4">
                                                <div class="flex items-center">
                                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-16 h-16 object-cover rounded mr-4">
                                                    <div>
                                                        <h3 class="font-bold text-gray-800">{{ $details['name'] }}</h3>
                                                        <p class="text-xs text-gray-500">Confecção: {{ $details['production_days'] }} dias</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 text-center">
                                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center justify-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <input type="hidden" name="zipcode" value="{{ $zipcode }}">
                                                    
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                                           min="1" class="w-16 text-center border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                                                           onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="p-4 text-right font-bold text-gray-700">
                                                R$ {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                                            </td>
                                            <td class="p-4 text-center">
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-2.138-1.958L4.857 7M10 11v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('shop') }}" class="text-teal-600 hover:text-teal-800 font-semibold text-sm">&larr; Continuar Comprando</a>
                        </div>
                    </div>

                    <div class="lg:w-1/3 space-y-6">
                        
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Resumo do Pedido</h2>
                            <div class="flex justify-between mb-2 text-gray-600">
                                <span>Subtotal Produtos</span>
                                <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between mb-4 text-sm text-orange-600 bg-orange-50 p-2 rounded">
                                <span>Tempo de Produção:</span>
                                <span class="font-bold">{{ $totalProductionDays }} dias úteis</span>
                            </div>

                            <form action="{{ route('cart.shipping') }}" method="GET" class="mb-4 border-t pt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Calcular Frete e Prazo</label>
                                <div class="flex gap-2">
                                    <input type="text" name="zipcode" value="{{ $zipcode ?? '' }}" placeholder="00000-000" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">OK</button>
                                </div>
                            </form>

                            @if(!empty($shippingOptions))
                                <div class="bg-gray-50 p-3 rounded mb-4 text-sm">
                                    <p class="font-bold text-gray-700 mb-2">Opções para {{ $zipcode }}:</p>
                                    @foreach($shippingOptions as $option)
                                        <div class="flex justify-between items-center mb-2 border-b last:border-0 pb-1">
                                            <div>
                                                <span class="block font-medium">{{ $option['name'] }}</span>
                                                <span class="text-xs text-gray-500">
                                                    Chega em aprox. <strong class="text-teal-600">{{ $totalProductionDays + $option['days'] }} dias</strong>
                                                    <br>(Produção + Entrega)
                                                </span>
                                            </div>
                                            <span class="font-bold text-gray-800">
                                                {{ $option['price'] > 0 ? 'R$ '.number_format($option['price'], 2, ',', '.') : 'Grátis' }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="border-t pt-4 flex justify-between items-center mb-6">
                                <span class="text-xl font-bold text-gray-800">Total (s/ frete)</span>
                                <span class="text-xl font-bold text-teal-600">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full bg-teal-500 text-white text-center font-bold py-3 rounded hover:bg-teal-600 transition shadow">
                                Finalizar Compra
                            </a>
                        </div>
                    </div>

                </div>
            @else
                <div class="text-center py-20 bg-white rounded-lg shadow">
                    <p class="text-gray-500 text-lg mb-6">Seu carrinho está vazio.</p>
                    <a href="{{ route('shop') }}" class="bg-teal-500 text-white px-6 py-3 rounded-full font-bold hover:bg-teal-600 transition">
                        Ver Produtos
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-site-layout>
