<x-site-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4">
            
            <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Resumo e Pagamento</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-2 text-teal-600">Entregar em:</h3>
                        <p class="text-gray-700">{{ $address['street'] }}, {{ $address['number'] }}</p>
                        <p class="text-gray-600">{{ $address['district'] }} - {{ $address['city'] }}/{{ $address['state'] }}</p>
                        <a href="{{ route('checkout.index') }}" class="text-sm text-blue-500 hover:underline mt-2 inline-block">Alterar endereço</a>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-4 text-teal-600">Itens do Pedido</h3>
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $item)
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                            <div class="flex justify-between py-2 border-b last:border-0">
                                <div>
                                    <span class="font-bold">{{ $item['quantity'] }}x</span> {{ $item['name'] }}
                                </div>
                                <div>R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</div>
                            </div>
                        @endforeach
                        <div class="flex justify-between pt-4 font-bold text-gray-700">
                            <span>Subtotal:</span>
                            <span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow h-fit">
                    <form action="{{ route('checkout.placeOrder') }}" method="POST">
                        @csrf
                        
                        <h3 class="font-bold text-lg mb-4 text-teal-600">Escolha o Frete</h3>
                        
                        <div class="space-y-3 mb-6">
                            @foreach($shippingOptions as $index => $option)
                                <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:bg-teal-50 hover:border-teal-300 transition">
                                    <div class="flex items-center">
                                        {{-- Mantivemos a correção do código/id/nome aqui --}}
                                        <input type="radio" name="shipping_option" value="{{ $option['code'] ?? $option['id'] ?? $option['name'] }}|{{ $option['price'] }}" 
                                               class="h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300" 
                                               onclick="updateTotal('{{ $subtotal }}', '{{ $option['price'] }}')"
                                               required {{ $index == 0 ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-900">{{ $option['name'] }}</span>
                                            <span class="block text-xs text-gray-500">{{ $option['days'] > 0 ? 'Até '.$option['days'].' dias úteis' : 'Imediato' }}</span>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-800">
                                        {{ $option['price'] > 0 ? 'R$ '.number_format($option['price'], 2, ',', '.') : 'Grátis' }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-xl font-bold text-gray-900">
                                <span>Total Final:</span>
                                <span id="final-total">...</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:scale-105">
                            FINALIZAR PEDIDO
                        </button>

                        {{-- BOTÃO DE CANCELAR ADICIONADO ABAIXO --}}
                        <a href="{{ route('cart.index') }}" class="block w-full text-center mt-3 bg-red-50 border border-red-100 hover:bg-red-100 text-red-600 font-bold py-4 rounded-lg transition">
                            CANCELAR COMPRA
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotal(subtotal, shipping) {
            let total = parseFloat(subtotal) + parseFloat(shipping);
            document.getElementById('final-total').innerText = 'R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
        }

        // Atualiza ao carregar a página com a primeira opção selecionada
        window.onload = function() {
            let selected = document.querySelector('input[name="shipping_option"]:checked');
            if(selected) {
                let val = selected.value.split('|')[1];
                updateTotal('{{ $subtotal }}', val);
            }
        }
    </script>
</x-site-layout>
