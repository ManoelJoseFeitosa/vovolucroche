<x-site-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-800">Identificação</h1>
                <p class="text-gray-500 mt-2">Faça login ou cadastre-se para finalizar seu pedido.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16">
                
                <div class="bg-white p-8 rounded-lg shadow-sm h-fit">
                    <h2 class="text-xl font-bold text-teal-600 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Já sou Cliente
                    </h2>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="redirect_to" value="checkout.payment">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">E-mail</label>
                            <input type="email" name="email" class="w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
                            <input type="password" name="password" class="w-full border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500" required>
                        </div>

                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg transition">
                            ENTRAR E FINALIZAR
                        </button>
                    </form>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-lg border-t-4 border-teal-500">
                    <h2 class="text-xl font-bold text-teal-600 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Criar Conta e Finalizar
                    </h2>

                    <form method="POST" action="{{ route('checkout.register') }}">
                        @csrf

                        <div class="space-y-4 mb-6">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b pb-2">Dados Pessoais</h3>
                            
                            <div>
                                <label class="block text-sm text-gray-600">Nome Completo</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded focus:ring-teal-500" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600">CPF</label>
                                    <input type="text" name="cpf" value="{{ old('cpf') }}" class="w-full border-gray-300 rounded focus:ring-teal-500" placeholder="000.000.000-00" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600">Celular/WhatsApp</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded focus:ring-teal-500" placeholder="(00) 00000-0000" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600">E-mail</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded focus:ring-teal-500" required>
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600">Criar Senha</label>
                                <input type="password" name="password" class="w-full border-gray-300 rounded focus:ring-teal-500" minlength="6" required>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b pb-2">Endereço de Entrega</h3>
                            
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    <label class="block text-sm text-gray-600">CEP</label>
                                    <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" class="w-full border-gray-300 rounded focus:ring-teal-500" required onblur="pesquisacep(this.value);">
                                </div>
                                <div class="col-span-2 flex items-end">
                                    <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" class="text-xs text-blue-500 hover:underline mb-3">Não sei meu CEP</a>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4">
                                <div class="col-span-3">
                                    <label class="block text-sm text-gray-600">Rua/Avenida</label>
                                    <input type="text" name="street" id="street" value="{{ old('street') }}" class="w-full border-gray-300 rounded focus:ring-teal-500 bg-gray-50" readonly required>
                                </div>
                                <div class="col-span-1">
                                    <label class="block text-sm text-gray-600">Número</label>
                                    <input type="text" name="number" value="{{ old('number') }}" class="w-full border-gray-300 rounded focus:ring-teal-500" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600">Bairro</label>
                                    <input type="text" name="district" id="district" value="{{ old('district') }}" class="w-full border-gray-300 rounded focus:ring-teal-500 bg-gray-50" readonly required>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600">Cidade/UF</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="w-full border-gray-300 rounded bg-gray-50" readonly required>
                                        <input type="text" name="state" id="state" value="{{ old('state') }}" class="w-16 border-gray-300 rounded bg-gray-50" readonly required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:scale-105">
                            CADASTRAR E IR PARA PAGAMENTO
                        </button>
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
    </script>
</x-site-layout>
