<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Produtos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.products.create') }}" 
                   class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded shadow transition duration-200">
                    + Novo Produto
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3 font-semibold text-gray-600">Imagem</th>
                                <th class="p-3 font-semibold text-gray-600">Nome</th>
                                <th class="p-3 font-semibold text-gray-600">Preço</th>
                                <th class="p-3 font-semibold text-gray-600">Prazo (Dias)</th>
                                <th class="p-3 font-semibold text-gray-600">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="border-b hover:bg-gray-50 transition duration-150">
                                <td class="p-3">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-16 h-16 object-cover rounded border border-gray-200">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">
                                            Sem foto
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3 font-medium text-gray-800">{{ $product->name }}</td>
                                <td class="p-3 text-gray-600">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td class="p-3 text-teal-600 font-bold">{{ $product->production_days }} dias</td>
                                <td class="p-3 flex gap-3 items-center mt-4">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 font-medium">Editar</a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($products->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 mb-2">Nenhum produto cadastrado ainda.</p>
                            <p class="text-sm text-gray-400">Clique no botão acima para começar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
