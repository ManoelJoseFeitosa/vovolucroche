<x-site-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg text-center border-t-4 border-green-500">
            
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6 animate-bounce">
                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Pedido Realizado!
            </h2>
            
            <p class="text-gray-500 mb-8">
                Obrigado por comprar na Vovó Lu Crochê. <br>
                Estamos aguardando a confirmação do pagamento pelo Mercado Pago.
            </p>

            <div class="bg-gray-50 rounded-lg p-4 mb-8 text-sm text-gray-600 text-left">
                <p class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Você receberá um e-mail com os detalhes.
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Acompanhe o status em 
                    <a href="{{ route('customer.dashboard') }}" class="text-teal-600 font-bold hover:underline">Minha Conta</a>.
                </p>
            </div>

            <div class="space-y-3">
                <a href="{{ route('shop') }}" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-bold rounded-md text-white bg-teal-600 hover:bg-teal-700 md:text-lg transition transform hover:scale-105 shadow-md">
                    🛍️ Continuar Comprando
                </a>

                <a href="{{ route('customer.dashboard') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 md:text-lg transition">
                    Ver Meus Pedidos
                </a>
            </div>

        </div>
    </div>
</x-site-layout>
