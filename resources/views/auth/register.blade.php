<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-700">Crie sua conta</h2>
        <p class="text-sm text-gray-500">Preencha os dados abaixo para comprar na loja.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nome Completo</label>
                <input id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <label for="email" class="block font-medium text-sm text-gray-700">E-mail</label>
                <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="cpf" class="block font-medium text-sm text-gray-700">CPF</label>
                    <input id="cpf" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="text" name="cpf" :value="old('cpf')" required placeholder="000.000.000-00" />
                    <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                </div>
                <div>
                    <label for="phone" class="block font-medium text-sm text-gray-700">Celular</label>
                    <input id="phone" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" type="text" name="phone" :value="old('phone')" required placeholder="(00) 00000-0000" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block font-medium text-sm text-gray-700">Senha</label>
                    <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div>
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar</label>
                    <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    type="password"
                                    name="password_confirmation"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        <div class="space-y-4">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Endereço de Entrega</h3>

            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-1">
                    <label class="block font-medium text-sm text-gray-700">CEP</label>
                    <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required onblur="pesquisacep(this.value);">
                </div>
                <div class="col-span-2 flex items-end">
                    <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" class="text-xs text-blue-500 hover:underline mb-3">Não sei meu CEP</a>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-3">
                    <label class="block font-medium text-sm text-gray-700">Rua</label>
                    <input type="text" name="street" id="street" value="{{ old('street') }}" class="block mt-1 w-full border-gray-300 rounded-md bg-gray-50 focus:border-teal-500 focus:ring-teal-500" readonly required>
                </div>
                <div class="col-span-1">
                    <label class="block font-medium text-sm text-gray-700">Nº</label>
                    <input type="text" name="number" value="{{ old('number') }}" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700">Bairro</label>
                    <input type="text" name="district" id="district" value="{{ old('district') }}" class="block mt-1 w-full border-gray-300 rounded-md bg-gray-50 focus:border-teal-500 focus:ring-teal-500" readonly required>
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700">Cidade/UF</label>
                    <div class="flex gap-2">
                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="block mt-1 w-full border-gray-300 rounded-md bg-gray-50" readonly required>
                        <input type="text" name="state" id="state" value="{{ old('state') }}" class="block mt-1 w-14 border-gray-300 rounded-md bg-gray-50" readonly required>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 flex-col gap-3">
            <x-primary-button class="w-full justify-center bg-teal-600 hover:bg-teal-700 py-3 text-base">
                Cadastrar
            </x-primary-button>
            
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" href="{{ route('login') }}">
                Já possui cadastro? Entrar
            </a>
        </div>
    </form>

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
</x-guest-layout>
