<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pedido #{{ $order->id }} - Detalhes
            </h2>
            
            {{-- Badge de Status Traduzida --}}
            @php
                $statusMap = [
                    'pending' => ['Pendente', 'bg-yellow-100 text-yellow-800'],
                    'paid' => ['Pago', 'bg-green-100 text-green-800'],
                    'shipped' => ['Enviado', 'bg-blue-100 text-blue-800'],
                    'delivered' => ['Entregue', 'bg-gray-100 text-gray-800'],
                    'canceled' => ['Cancelado', 'bg-red-100 text-red-800'],
                ];
                $statusInfo = $statusMap[$order->status] ?? [$order->status, 'bg-gray-100 text-gray-800'];
            @endphp
            
            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $statusInfo[1] }}">
                {{ $statusInfo[0] }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white shadow rounded-lg p-6 h-fit border-l-4 border-teal-500">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Dados do Cliente
                    </h3>
                    <p class="mb-1"><strong class="text-gray-600">Nome:</strong> {{ $order->customer_name }}</p>
                    <p class="mb-1"><strong class="text-gray-600">Email:</strong> {{ $order->customer_email }}</p>
                    <p class="mb-1"><strong class="text-gray-600">Telefone:</strong> {{ $order->customer_phone }}</p>
                    <p class="mb-1"><strong class="text-gray-600">CPF:</strong> {{ $order->customer_cpf ?? 'Não informado' }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 h-fit border-l-4 border-teal-500">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Endereço de Entrega
                    </h3>
                    <p class="text-lg font-medium text-gray-800">{{ $order->street }}, {{ $order->number }}</p>
                    <p class="text-gray-600">{{ $order->district }}</p>
                    <p class="text-gray-600">{{ $order->city }} - {{ $order->state }}</p>
                    <p class="text-gray-500 text-sm mt-2">CEP: {{ $order->zipcode }}</p>
                    @if($order->complement)
                        <p class="text-gray-500 text-sm">Comp: {{ $order->complement }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Itens do Pedido</h3>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="p-3">Produto</th>
                            <th class="p-3 text-center">Qtd</th>
                            <th class="p-3 text-right">Preço Unit.</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="p-3 font-medium text-gray-800">{{ $item->product_name }}</td>
                            <td class="p-3 text-center">{{ $item->quantity }}</td>
                            <td class="p-3 text-right">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                            <td class="p-3 text-right font-bold text-teal-600">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="flex justify-end mt-6 pt-4 border-t">
                    <div class="text-right">
                        <span class="text-gray-500 text-sm">Total do Pedido</span>
                        <div class="text-2xl font-bold text-teal-600">R$ {{ number_format($order->total_price, 2, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Gerenciar Envio</h3>
                
                @if($order->status == 'shipped')
                    <div class="text-green-600 font-bold bg-green-100 p-3 rounded">
                        ✓ Este pedido já foi marcado como enviado!
                    </div>
                @else
                    <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                        @csrf
                        <div class="w-full md:w-1/2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código de Rastreio (Opcional)</label>
                            <input type="text" name="tracking_code" placeholder="Ex: AA123456789BR" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded hover:bg-blue-700 transition font-bold shadow">
                            Marcar como Enviado & Avisar Cliente
                        </button>
                    </form>
                @endif
            </div>

            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-teal-600 hover:underline flex items-center gap-1 transition">
                    &larr; Voltar para Lista
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
