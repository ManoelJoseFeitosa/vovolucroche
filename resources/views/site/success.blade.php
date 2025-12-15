<x-site-layout>
    <div class="py-20 text-center bg-gray-50">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <div class="text-green-500 mb-4 flex justify-center">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pagamento Recebido!</h1>
            <p class="text-gray-600 mb-6">Seu pedido foi processado com sucesso pelo Mercado Pago.</p>
            
            <a href="{{ route('shop') }}" class="block w-full bg-teal-500 text-white font-bold py-3 rounded-lg shadow hover:bg-teal-600 transition">
                Voltar para a Loja
            </a>
        </div>
    </div>
</x-site-layout>
