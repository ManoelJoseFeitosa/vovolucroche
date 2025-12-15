<x-site-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Seu Carrinho de Compras</h1>

            @if(session('success'))
                <div class="bg-teal-100 border border-teal-400 text-teal-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('cart') && count(session('cart')) > 0)
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <table class="w-full text-left">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6">Produto</th>
                                        <th class="py-3 px-6 text-center">Prazo Confecção</th>
                                        <th class="py-3 px-6 text-center">Qtd</th>
                                        <th class="py-3 px-6 text-right">Preço</th>
                                        <th class="py-3 px-6 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach(session('cart') as $id => $details)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 flex items-center gap-4">
                                            <div class="w-12 h-12 flex-shrink-0">
                                                @if($details['image'])
                                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover rounded border">
                                                @else
                                                    <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-xs">Sem foto</div>
                                                @endif
                                            </div>
                                            <span class="font-medium">{{ $details['name'] }}</span>
                                        </td>
                                        <td class="py-3 px-6 text-center text-teal-600 font-bold">
                                            {{ $details['production_days'] }} dias
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            {{ $details['quantity'] }}
                                        </td>
                                        <td class="py-3 px-6 text-right font-bold">
                                            R$ {{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button class="text-red-500 hover:text-red-700 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('shop') }}" class="text-teal-600 font-bold hover:underline">&larr; Continuar Comprando</a>
                        </div>
                    </div>

                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-6">Resumo do Pedido</h2>
                            
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal Produtos</span>
                                <span class="font-bold">R$ {{ number_format($totalPrice, 2, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between mb-4 border-b pb-4">
                                <span class="text-gray-600">Tempo Total Confecção</span>
                                <span class="font-bold text-teal-600">{{ $totalProductionDays }} dias úteis</span>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Calcular Frete e Prazo</label>
                                <div class="flex gap-2">
                                    <input type="text" placeholder="CEP" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm font-bold">OK</button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Informe o CEP para ver o valor da entrega.</p>
                            </div>

                            <div class="flex justify-between mb-6 text-xl font-bold text-gray-800">
                                <span>Total</span>
                                <span>R$ {{ number_format($totalPrice, 2, ',', '.') }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-teal-500 text-white font-bold py-3 rounded-lg shadow hover:bg-teal-600 transition">
                                Finalizar Compra
                            </a>
                        </div>
                    </div>

                </div>
            @else
                <div class="text-center py-20 bg-white rounded-lg shadow">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <h2 class="text-2xl font-bold text-gray-600 mb-2">Seu carrinho está vazio</h2>
                    <p class="text-gray-500 mb-6">Que tal dar uma olhada nas novidades?</p>
                    <a href="{{ route('shop') }}" class="bg-teal-500 text-white font-bold py-3 px-8 rounded-lg shadow hover:bg-teal-600 transition">
                        Ver Produtos
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-site-layout>
