@extends('PRF.base')

@section('title', 'Página Inicial')

@section('content')

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <div class="flex justify-between">
          <a href="/">
            <img src="/images/logo-hc.png" alt="">
          </a>
          <div class="relative w-full max-w-[200px]">
            <button class="btn btn-secondary dropdown-toggle ms-auto flex gap-4 items-center hover:bg-gray-6 transition-all rounded-full p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="/images/svg/user-circle.svg" alt="" class="rounded-full w-8 h-8 object-cover">
              {{-- <p class="font-bold text-gray-1 text-sm font-poppins hidden sm:block">
                Usuário da Silva
              </p> --}}
            </button>
            <ul class="dropdown-menu absolute right-0 shadow-sm w-full mt-2 bg-white rounded-lg border py-2">
              <li>
                <a href="/login" class="inline-flex gap-2 py-2 px-3.5 w-full hover:bg-gray-6 transition-all">
                  <span class="text-gray-1 font-medium ">
                    Faça Login
                  </span>
                </a>
              </li>
              {{-- <li>
                <a class="inline-flex items-center gap-2 py-2 px-3.5 w-full hover:bg-gray-6 transition-all" href="">
                  <span class="text-brand-v1 font-medium ">
                    Sair
                  </span>
                  <img src="/images/svg/logout.svg" alt="">
                </a>
              </li> --}}
            </ul>
          </div>
        </div>
      </div>
    </header>

    <main class="container grow pt-6 pb-32">
      {{-- <img src="/images/PRF/banner-mobile.png" class="md:hidden w-full" alt="">
      <img src="/images/PRF/banner-desktop.png" class="hidden md:block w-full" alt=""> --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 pt-8 gap-6">
        <div class="col-span-2 lg:col-span-1">
          <img src="/images/seminario-banner.jpg" alt="">
        </div>
        <div class="col-span-2 lg:col-span-1">
          <div class="border border-gray-5 rounded-md p-4">
            <h1 class="text-xl font-bold text-gray-1 mb-6">Inscreva-se</h1>
            <form action="/registration/store" method="POST" class="">
              @csrf

              <div class="space-y-4">
                <div>
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="registration_cpf_field">
                    CPF
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="registration_cpf_field" name="cpf" placeholder="Digite o seu CPF" value="{{ old('cpf') }}" />
                </div>
                <div>
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="registration_nome_field">
                    Nome completo
                  </label>
                  <input onkeyup="this.value = this.value.toUpperCase();" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="registration_nome_field" name="nome" value="{{ old('nome') }}" placeholder="Digite o seu nome completo" />
                </div>
                <div>
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="registration_phone_field">
                    Contato
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="registration_phone_field" placeholder="Digite o seu número de contato" name="phone" value="{{ old('phone') }}" />
                </div>
                <div>
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="registration_email_field">
                    E-mail
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="registration_email_field" placeholder="Digite o seu E-mail" name="email" value="{{ old('email') }}" />
                </div>
                <div>
                  <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="registration_password_field">
                    Senha
                  </label>
                  <div class="group relative">
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3" type="password" id="registration_password_field" name="password" placeholder="Digite a sua senha" />
                    <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                      <button type="button" data-inputId="registration_password_field" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                        <img src="/images/PRF/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                        <img src="/images/PRF/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                      </button>
                    </div>
                    <div class="text-gray-1 text-sm mt-2">
                      <p>
                        A senha deve ter:
                      </p>
                      <ul>
                        <li>- Minimo de 8 caracteres</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div>
                  <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="confirm_password_field">
                    Confirmação de senha
                  </label>
                  <div class="group relative">
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3" type="password" id="confirm_password_field" name="confirm_password" placeholder="Digite novamente a sua senha" />
                    <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                      <button type="button" data-inputId="confirm_password_field" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                        <img src="/images/PRF/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                        <img src="/images/PRF/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                      </button>
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="registration_is_servidor_field">
                    É servidor da segurança pública?
                  </label>

                  <div class="relative">
                    <select data-item="select" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="is_servidor" id="registration_is_servidor_field">
                      <option @if (old('is_servidor') == 0) @selected(true) @endif value="0">Não</option>
                      <option @if (old('is_servidor') == 1) @selected(true) @endif value="1">Sim</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
                <div id="servidor_info" class="hidden">
                  <div class="bg-feedback-fill-blue p-4 rounded-lg border border-blue-400" role="alert">
                    <p class="text-sm mb-2">
                      <strong>Atenção:</strong> Até o dia <strong>15 de setembro</strong>, a inscrição do Profissional da Segurança Pública será confirmada mediante a entrega de 02 quilos de alimentos no Quartel do Comando Geral do Corpo de Bombeiros Militar do RN.
                    </p>

                    <p class="text-sm mb-2">
                      Caso prefira, pode fazer a inscrição com o pagamento de R$ 10,00 na modalidade de <strong>”NÃO Profissional da Segurança Pública”</strong>.
                    </p>

                    <p class="text-sm mb-1">
                      <strong>Local da entrega:</strong>
                    </p>

                    <p class="text-sm mb-2">
                      Quartel do Comando Geral do Corpo de Bombeiros - Av. Prudente de Morais, 2410, Barro Vermelho - Natal.
                    </p>

                    <p class="text-sm">
                      <strong>De segunda a sexta feira:</strong> Das 8h às 13h
                    </p>
                    <p class="text-sm">
                      <strong>Maiores informações: </strong> (84) 98129-3618
                    </p>
                  </div>
                </div>
                <h2 class="text-gray-1 text-xl font-semibold font-poppins">
                  Aceite obrigatório
                </h2>
                <hr class="my-4 border-gray-4" />
                <p class="text-sm text-gray-1 mb-8">
                  “Aceito as regras de participação do SEMINÁRIO DE SAÚDE MENTAL E PREVENÇÃO DO SUICÍDIO e a POLÍTICA DE TRATAMENTO DE DADOS, nos limites das suas finalidades institucionais, observando o norteamento jurídico da Lei 13.709/2018 (Lei Geral de Proteção de Dados – LGPD).”
                </p>
                <div class="flex items-center gap-2">
                  <input data-conditional="submit_button" type="checkbox" id="registration_terms_checkbox" name="registration_terms_checkbox" class="checkbox" required />
                  <p class="block pb-1 text-sm font-semibold text-brand-prfA1 underline">
                    Li e aceito os termos.
                  </p>
                </div>
                <hr class="mt-20 mb-8 border-gray-4" />

                <button disabled id="submit_button" data-conditional-button type="submit" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
                  <p class="text-white text-sm font-bold font-poppins">
                    Cadastrar-se
                  </p>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>

    <footer class="bg-fill-1 pt-16 pb-8 bottom-0 w-full">
      <div class="container border-t border-gray-3">
        <div class="grid grid-cols-1 md:grid-cols-2 pt-4 gap-4">
          <div>
            <p class="text-xs text-gray-1">
              <?= date('Y') ?> HC Sports. Todos os direitos reservados.
            </p>
          </div>
          <div class="flex justify-end gap-4">
            <a href="https://www.youtube.com/@hcsports6389" target="_blank">
              <img src="/images/svg/youtube.svg" alt="">
            </a>
            <a href="https://twitter.com/HCSportsBR" target="_blank">
              <img src="/images/svg/twitter.svg" alt="">
            </a>
            <a href="https://www.facebook.com/HCSportsBR" target="_blank">
              <img src="/images/svg/facebook.svg" alt="">
            </a>
            <a href="https://www.instagram.com/hcsportsbr/" target="_blank">
              <img src="/images/svg/instagram.svg" alt="">
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('erro') }}') {
      showErrorToastfy('{{ session('erro') }}');
    }

    if ('{{ session('success') }}') {
      showSuccessToastfy('{{ session('success') }}');
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
        onClick: function() {}
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
        onClick: function() {}
      }).showToast();
    }

    new Cleave('#registration_cpf_field', {
      blocks: [3, 3, 3, 2],
      delimiters: ['.', '.', '-'],
      numericOnly: true,
    });

    new Cleave('#registration_phone_field', {
      blocks: [2, 5, 4],
      delimiters: [' ', '-'],
      numericOnly: true,
    });

    const isServidor = document.querySelector('#registration_is_servidor_field');
    const servidorInfo = document.querySelector('#servidor_info');

    isServidor.addEventListener('change', handleIsServidorSelect);

    function handleIsServidorSelect(e) {
      if (e.target.value == '1') {
        servidorInfo.classList.remove('hidden');
      } else {
        servidorInfo.classList.add('hidden');
      }
    }
  </script>
@endsection
