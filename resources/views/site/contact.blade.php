<x-site-layout>
    
    <div class="bg-teal-50 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Fale Conosco</h1>
            <p class="text-gray-600 mt-2">Estamos à disposição para tirar dúvidas sobre suas encomendas.</p>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16">
            
            <div class="flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 relative inline-block">
                    Canais de Atendimento
                    <span class="block h-1 w-16 bg-teal-500 mt-2 rounded-full"></span>
                </h2>
                
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Quer personalizar uma peça, saber o prazo exato ou apenas dar um "oi"? 
                    Entre em contato conosco pelos canais abaixo. Respondemos o mais rápido possível!
                </p>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-teal-100 p-3 rounded-full text-teal-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">WhatsApp</h3>
                            <p class="text-gray-600 text-sm mb-1">(86) 99924-0325</p>
                            <a href="https://wa.me/5586999240325" target="_blank" class="text-teal-600 font-bold text-sm hover:underline">
                                Iniciar conversa &rarr;
                            </a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="bg-teal-100 p-3 rounded-full text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Localização</h3>
                            <p class="text-gray-600 text-sm">Teresina - Piauí</p>
                            <p class="text-xs text-gray-400 mt-1">Enviamos para todo o Brasil</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-8 rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Envie uma mensagem</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf 
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Seu Nome</label>
                        <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Como podemos te chamar?" required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Seu E-mail</label>
                        <input type="email" id="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="email@exemplo.com" required>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Assunto</label>
                        <select id="subject" name="subject" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50">
                            <option>Dúvida sobre Produto</option>
                            <option>Encomenda Personalizada</option>
                            <option>Status do Pedido</option>
                            <option>Outros</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensagem</label>
                        <textarea id="message" name="message" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50" placeholder="Escreva aqui sua dúvida..." required></textarea>
                    </div>

                    <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200 transform hover:-translate-y-1">
                        Enviar Mensagem
                    </button>
                </form>
            </div>

        </div>
    </div>

</x-site-layout>
