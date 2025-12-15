<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nome da Peça:</label>
                            <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required>{{ $product->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Preço (R$):</label>
                                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Peso (Kg):</label>
                                <input type="number" step="0.001" name="weight" value="{{ $product->weight }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                <p class="text-xs text-gray-500 mt-1">Ex: 0.500 para 500g</p>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Dias Produção:</label>
                                <input type="number" name="production_days" value="{{ $product->production_days }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_featured" class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700 font-bold">Destacar na Home Page?</span>
                            </label>
                        </div>

                        @if($product->image_path)
                            <div class="mb-2">
                                <p class="text-sm text-gray-600">Imagem atual:</p>
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="w-32 rounded shadow border border-gray-200">
                            </div>
                        @endif

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Alterar Foto (Opcional):</label>
                            <input type="file" name="image" class="w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-500 file:text-white hover:file:bg-teal-600 transition">
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-teal-500 text-white font-bold rounded hover:bg-teal-600 shadow transition">Atualizar Produto</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
