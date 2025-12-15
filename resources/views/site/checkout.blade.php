<x-site-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-center mb-10">
                <div class="flex items-center text-teal-600">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-teal-600 bg-teal-600 text-white flex items-center justify-center font-bold">1</div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-teal-600">Carrinho</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-teal-600"></div>
                <div class="flex items-center text-teal-600">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-teal-600 bg-teal-600 text-white flex items-center justify-center font-bold">2</div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-teal-600">Identificação</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                <div class="flex items-center text-gray-500">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-300 flex items-center justify-center font-bold">3</div>
                    <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Pagamento</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 md:p-10">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Dados de Entrega</h1>
                    <p class="text-gray-500 mb-8">Preencha os dados abaixo para calcularmos o frete final.</p>

                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf

                        <h2 class="text-lg font-semibold text-teal-600 mb-4 border-b pb-2">1. Quem vai receber?</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nome Completo</label>
                                <input type="text" name="fullname" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">CPF (Para Nota Fiscal)</label>
                                <input type="text" name="cpf" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="000.000.000-00">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">E-mail</label>
                                <input type="email" name="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp / Telefone</label>
                                <input type="text" name="phone" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="(99) 99999-9999" required>
                            </div>
                        </div>

                        <h2 class="text-lg font-semibold text-teal-600 mb-4 border-b pb-2 mt-8">2. Onde devemos entregar?</h2>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">CEP</label>
                            <div class="flex gap-4">
                                <input type="text" id="zipcode" name="zipcode" class="w-40 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="00000-000" maxlength="9" onblur="pesquisacep(this.value);" required>
                                <span class="text-sm text-gray-400 flex items-center">Digite para buscar o endereço</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rua / Avenida</label>
                                <input type="text" id="street" name="street" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 bg-gray-50" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Número</label>
                                <input type="text" name="number" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Bairro</label>
                                <input type="text" id="district" name="district" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 bg-gray-50" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Cidade</label>
                                <input type="text" id="city" name="city" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 bg-gray-50" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Estado</label>
                                <input type="text" id="state" name="state" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 bg-gray-50" required>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Complemento (Opcional)</label>
                            <input type="text" name="complement" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Ex: Apartamento 101, Bloco B">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg transition duration-200 text-lg">
                                Ir para Pagamento &rarr;
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function limpa_formulário_cep() {
            document.getElementById('street').value=("");
            document.getElementById('district').value=("");
            document.getElementById('city').value=("");
            document.getElementById('state').value=("");
    }

    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                document.getElementById('street').value="...";
                document.getElementById('district').value="...";
                document.getElementById('city').value="...";
                document.getElementById('state').value="...";

                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                document.body.appendChild(script);
            } else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulário_cep();
        }
    };

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('street').value=(conteudo.logradouro);
            document.getElementById('district').value=(conteudo.bairro);
            document.getElementById('city').value=(conteudo.localidade);
            document.getElementById('state').value=(conteudo.uf);
        } else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
    </script>
</x-site-layout>
