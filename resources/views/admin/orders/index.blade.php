<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                                <th class="p-3">#ID</th>
                                <th class="p-3">Cliente</th>
                                <th class="p-3">Data</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3 font-bold">#{{ $order->id }}</td>
                                <td class="p-3">
                                    {{ $order->customer_name }}<br>
                                    <span class="text-xs text-gray-500">{{ $order->city }}/{{ $order->state }}</span>
                                </td>
                                <td class="p-3 text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="p-3 font-bold text-teal-600">R$ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                                <td class="p-3">
                                    {{-- Lógica de Tradução e Cores --}}
                                    @php
                                        $statusConfig = match($order->status) {
                                            'pending' => ['text' => 'Pendente', 'class' => 'bg-yellow-100 text-yellow-800 border border-yellow-200'],
                                            'paid' => ['text' => 'Pago', 'class' => 'bg-green-100 text-green-800 border border-green-200'],
                                            'shipped' => ['text' => 'Enviado', 'class' => 'bg-blue-100 text-blue-800 border border-blue-200'],
                                            'delivered' => ['text' => 'Entregue', 'class' => 'bg-gray-100 text-gray-800 border border-gray-200'],
                                            'canceled' => ['text' => 'Cancelado', 'class' => 'bg-red-100 text-red-800 border border-red-200'],
                                            default => ['text' => $order->status, 'class' => 'bg-gray-100 text-gray-800']
                                        };
                                    @endphp

                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $statusConfig['class'] }}">
                                        {{ $statusConfig['text'] }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs uppercase border border-blue-200 hover:bg-blue-50 px-3 py-1 rounded transition">
                                        Ver Detalhes
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($orders->isEmpty())
                        <div class="text-center py-10 text-gray-500 bg-gray-50 rounded mt-4">
                            <p>Nenhum pedido realizado ainda.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
