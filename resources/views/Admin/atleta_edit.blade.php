@extends('User.base')

@section('title', 'Perfil')

@section('content')

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
                                <a href="/admin/users" class="text-xs text-gray-1 block hover:underline">
                                    Atletas
                                </a>
                            </div>
                            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
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
                                <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
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
                                            <input disabled
                                                class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                                type="text" id="cadastro_cpf_field" value="<?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $atleta->cpf); ?>" />
                                        </div>
                                        <div class="grow">
                                            <label class="text-gray-1 font-semibold text-base inline-block mb-2"
                                                for="cadastro_email_field">
                                                E-mail
                                            </label>
                                            <input disabled
                                                class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                                type="text" id="cadastro_email_field" value="{{ $atleta->email }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-gray-1 font-semibold text-base block mb-2"
                                            for="cadastro_nome_completo_field">
                                            Nome completo
                                        </label>
                                        <input required
                                        onkeyup="this.value = this.value.toUpperCase();"
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
                                            <input disabled
                                                class="w-full max-w-[200px] px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                                type="date" id="cadastro_nascimento_field"
                                                value="{{ $atleta->data_nasc }}" />
                                            <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                                                <img src="/images/svg/calendar.svg" alt="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="text-gray-1 font-semibold text-base block mb-2"
                                            for="input_text_exemplo">
                                            UF
                                        </label>
                                        <input disabled
                                            class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full max-w-[270px] break-all px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                            value="{{ $atleta->address->federativeUnit->name }}" type="text"
                                            id="input_text_exemplo" />
                                    </div>
                                    <div>
                                        <label class="text-gray-1 font-semibold text-base block mb-2"
                                            for="input_text_exemplo">
                                            Cidade
                                        </label>
                                        <input  value="{{ $atleta->address->cidade }}" required
                                        onkeyup="this.value = this.value.toUpperCase();"
                                            class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full max-w-[250px] px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition"
                                            type="text" id="input_text_exemplo" name="city"
                                            placeholder="Digite o nome da sua cidade" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input data-conditional="submit_button" type="checkbox"
                                            id="cadastro_termos_checkbox" name="pcd" class="checkbox"{{$atleta->is_pcd ? 'checked' : ''}} />
                                        <label class="block pb-1 text-sm font-semibold text-brand-a1 underline">
                                            PCD
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-dark-900 font-semibold text-base inline-block mb-2"
                                            for="cadastro_senha_field">
                                            Senha
                                        </label>
                                        <div class="group relative">
                                            <input
                                                class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3"
                                                type="password" id="cadastro_senha_field" name="password"
                                                placeholder="Digite a sua senha" />
                                            <div
                                                class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                                                <button type="button" data-inputId="cadastro_senha_field"
                                                    class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                                                    <img src="/images/svg/eye.svg" alt=""
                                                        class="hidden group-[.show]:block" />
                                                    <img src="/images/svg/eye-off.svg" alt=""
                                                        class="block group-[.show]:hidden" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-dark-900 font-semibold text-base inline-block mb-2"
                                            for="cadastro_senha_confirm_field">
                                            Confirmação de senha
                                        </label>
                                        <div class="group relative">
                                            <input
                                                class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3"
                                                type="password" id="cadastro_senha_confirm_field"
                                                name="password_confirm" placeholder="Digite a sua senha" />
                                            <div
                                                class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                                                <button type="button" data-inputId="cadastro_senha_confirm_field"
                                                    class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                                                    <img src="/images/svg/eye.svg" alt=""
                                                        class="hidden group-[.show]:block" />
                                                    <img src="/images/svg/eye-off.svg" alt=""
                                                        class="block group-[.show]:hidden" />
                                                </button>
                                            </div>
                                        </div>
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
    <script>
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
  </script>
@endsection
