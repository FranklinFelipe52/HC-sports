@extends('User.base')

@section('title', 'Perfil')

@section('content')

    @include('components.admin.menu_mobile', ['type' => 4])

    <!-- grid principal -->
    <div
        class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

        <!-- Menu lateral -->
        <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
            @include('components.admin.menu_lateral', ['type' => 4]);
        </div>

        <!-- corpo da página -->
        <div class="order-1 sm:order-2 overflow-hidden">
            <div class="h-full w-full flex flex-col overflow-auto pb-8">

                <!-- Cabeçalho -->
                <header class="pt-8 pb-6 space-y-6">
                    <div class="container">
                        <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
                            <div>
                                <a target="_self" href="{{route('users_admin')}}" class="text-xs text-gray-1 block hover:underline">
                                    Atletas
                                </a>
                            </div>
                            <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
                            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                                @if ($atleta->nome_completo)
                                    {{ $atleta->nome_completo }}
                                @else
                                    {{ $atleta->email }}
                                @endif
                            </div>
                        </nav>
                        <h1 class="text-lg text-gray-1 font-poppins font-semibold">
                            Atualização de dados
                        </h1>
                    </div>
                </header>

                <!-- conteúdo -->
                <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
                    <div class="md:col-span-3 lg:col-span-2">
                        <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex gap-4 sm:gap-8 md:block">
                            <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                                <img src="{{asset('/images/svg/user-circle.svg')}}" class="w-full h-full object-cover" alt="">
                            </div>

                        </div>
                    </div>
                    <div class="md:col-span-9 lg:col-span-10 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
                        <div class="w-full">
                            <form method="post">
                                @csrf
                                <div class="border border-gray-5 rounded-lg mb-6 p-4 sm:px-6 pb-6 space-y-6">
                                    <div class="flex flex-wrap gap-6">
                                        <div class="grow">
                                            <label class="text-gray-1 font-semibold text-base inline-block mb-2"
                                                for="cadastro_cpf_field">
                                                CPF
                                            </label>
                                            <input name="cpf" required
                                                class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                                type="text" id="cpf_adicionar_atleta_form" value="<?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $atleta->cpf); ?>" />
                                        </div>
                                       
                                        <div class="grow">
                                            <label class="text-gray-1 font-semibold text-base inline-block mb-2"
                                                for="cadastro_email_field">
                                                E-mail
                                            </label>
                                            <input required name="email"
                                                class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                                type="email" id="cadastro_email_field" value="{{ $atleta->email }}" />
                                        </div>
                                        
                                    </div>
                                    <div>
                                        <label class="text-gray-1 font-semibold text-base block mb-2"
                                            for="cadastro_nome_completo_field">
                                            Nome completo
                                        </label>
                                        <input onkeyup="this.value = this.value.toUpperCase();"
                                            class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full max-w-[321px] px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                            type="text" id="cadastro_nome_completo_field" name="nome"
                                            placeholder="Digite o seu nome completo" value="{{ $atleta->nome_completo }}" />
                                    </div>
                                    <div>
                                        <label class="text-dark-900 font-semibold text-base block mb-2"
                                            for="cadastro_nascimento_field">
                                            Nascimento
                                        </label>
                                        <div class="relative w-full max-w-[200px]">
                                            <input required name="date_nasc"
                                                class="w-full max-w-[200px] px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                                type="date" id="cadastro_nascimento_field"
                                                value="{{ $atleta->data_nasc }}" />
                                            <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                                                <img src="{{asset('/images/svg/calendar.svg')}}" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_genero_field">
                                          Gênero
                                        </label>
                                        <div class="relative">
                                            <select required data-preload="sexo-visible" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 appearance-none transition" name="sexo" id="cadastro_genero_field">
                                              <option value="M" @if ($atleta->sexo == 'M') selected @endif>Masculino</option>
                                              <option value="F" @if ($atleta->sexo == 'F') selected @endif>Feminino</option>
                                            </select>
                                          <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <img src="{{asset('/images/svg/chevron-down.svg')}}" alt="" />
                                          </div>
                                        </div>
                                      </div>
                                    <div>
                                        <label class="text-gray-1 font-semibold text-base inline-block mb-2"
                                            for="cadastro_phone_field">
                                            Celular
                                        </label>
                                        <input required
                                            onkeyup="this.value = this.value.replace(/\D+/g, '').replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');"
                                            maxlength="13" min="13" placeholder="Ex: (00) 0 0000-0000"
                                            class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                            name="phone_number" type="phone" id="cadastro_phone_field"
                                            value="{{ $atleta->phone_number }}" />
                                    </div>

                                    <div>
                                        <label class="text-gray-1 font-semibold text-base block mb-2"
                                            for="input_text_exemplo">
                                            UF
                                        </label>
                                        <select data-preload="uf-visible" required
                                            class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 appearance-none transition"
                                            name="uf" id="select_exemplo">
                                            <option value="" @if (!old('uf')) selected @endif
                                                disabled>
                                                Selecione
                                            </option>
                                            @foreach ($federative_units as $federative_unit)
                                                @if ($atleta->address->federativeUnit->id == $federative_unit->id)
                                                    <option value="{{ $federative_unit->id }}" selected>
                                                        {{ $federative_unit->initials }}</option>
                                                @else
                                                    <option value="{{ $federative_unit->id }}"
                                                        @if (old('uf') == $federative_unit->id) selected @endif>
                                                        {{ $federative_unit->initials }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-gray-1 font-semibold text-base block mb-2"
                                            for="input_text_exemplo">
                                            Cidade
                                        </label>
                                        <input value="{{ $atleta->address->cidade }}"
                                            onkeyup="this.value = this.value.toUpperCase();"
                                            class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full max-w-[250px] px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                            type="text" id="input_text_exemplo" name="city"
                                            placeholder="Digite o nome da sua cidade" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input data-conditional="submit_button" type="checkbox"
                                            id="cadastro_termos_checkbox" name="pcd"
                                            class="checkbox"{{ $atleta->is_pcd ? 'checked' : '' }} />
                                        <label class="block pb-1 text-sm font-semibold text-brand-a1 underline">
                                            PCD
                                        </label>
                                    </div>
                                    
                                </div>
                                <div class="flex gap-4 flex-wrap">
                                    <button type="submit"
                                        class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
                                        <p class="text-white text-sm font-bold font-poppins">
                                            Salvar alterações
                                        </p>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"
        integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const senhaInput = document.querySelector('#atleta_senha');
        const confirmarSenhaInput = document.querySelector('#atleta_confirmar_senha');
        const botaoGerarSenha = document.querySelector('#gerar-senha-botao');
        const botaoCopiarSenha = document.querySelector('#copiar-senha-botao');


        new Cleave('#cpf_adicionar_atleta_form', {
            blocks: [3, 3, 3, 2],
            delimiters: ['.', '.', '-'],
            numericOnly: true,
        });

        if ('{{ session('edit_error') }}') {
            showErrorToastfy('{{ session('edit_error') }}');
        }

        function showSuccessToastfy(text) {
            Toastify({
                text: text,
                duration: 3000,
                gravity: "top",
                close: true,
                position: "right",
                style: {
                    background: "#EBFBEE",
                    color: "#279424",
                    boxShadow: "none",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }

        function showErrorToastfy(text) {
            Toastify({
                text: text,
                duration: 3000,
                gravity: "top",
                close: true,
                position: "right",
                style: {
                    background: "#FBDBDB",
                    color: "#8E1014",
                    boxShadow: "none",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }

        function gerarSenhaForte() {
            var letrasMinusculas = "abcdefghijklmnopqrstuvwxyz";
            var letrasMaiusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var numeros = "0123456789";
            var caracteresEspeciais = "!@#$%^&*()_";
            var caracteres = letrasMinusculas + letrasMaiusculas + numeros + caracteresEspeciais;
            var tamanhoSenha = 12;

            var senha = "";
            senha += letrasMinusculas.charAt(Math.floor(Math.random() * letrasMinusculas.length));
            senha += letrasMaiusculas.charAt(Math.floor(Math.random() * letrasMaiusculas.length));
            senha += numeros.charAt(Math.floor(Math.random() * numeros.length));
            senha += caracteresEspeciais.charAt(Math.floor(Math.random() * caracteresEspeciais.length));

            for (var i = 4; i < tamanhoSenha; i++) {
                var randomIndex = Math.floor(Math.random() * caracteres.length);
                senha += caracteres.charAt(randomIndex);
            }

            senhaInput.value = senha;
            confirmarSenhaInput.value = senha;

            // showInfoToastfy('Lembre-se de copiar a senha antes de salvar as alterações');
            showSuccessToastfy('Senha gerada! Lembre-se de copiá-la antes de salvar as alterações');
        }

        function copiarSenha() {
            if (!senhaInput.value) return;

            var tempInput = document.createElement("input");
            tempInput.type = "text";
            tempInput.value = senhaInput.value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            showSuccessToastfy('Senha copiada!')
        }

        botaoGerarSenha.addEventListener('click', gerarSenhaForte);
        botaoCopiarSenha.addEventListener('click', copiarSenha);
    </script>
@endsection
