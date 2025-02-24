@extends('User.base')

@section('title', 'Perfil')

@section('profileClass', 'active')

@section('content')
<!-- grid principal -->
<div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

  <!-- Menu lateral -->
  <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
    @include('components.header');
  </div>

  <!-- corpo da página -->
  <div class="order-1 sm:order-2 overflow-hidden">
    @if (Session('user')->nome_completo == null || Session('user')->nome_completo == 'Nome')
        @include('components.edit_notification')
      @endif
    <div class="h-full w-full flex flex-col overflow-auto pb-8">

      <!-- Cabeçalho -->
      <header class="pt-8 pb-6 space-y-6">
        <div class="container">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
            <div>
              <a href="/inscricao/profile" class="text-xs text-gray-1 block hover:underline">
                Perfil
              </a>
            </div>
            <img src="/inscricao/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Alterar senha
            </div>
          </nav>
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Alterar de Senha
          </h1>
        </div>
      </header>



      <!-- conteúdo -->
      <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
        <div class="md:col-span-9 lg:col-span-6 flex flex-col overflow-hidden">
          <div class="w-full">
            <form method="post">
              @csrf
              <div class="border border-gray-5 rounded-lg mb-6 p-4 sm:px-6 pb-6 space-y-6">
                <p class="text-gray-1 text-sm">
                  Use o formulário a seguir para alterar a senha.
                </p>
                <div class="group w-full max-w-[320px]">
                  <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_senha_field">
                    Senha atual:
                  </label>
                  <div class="group relative">
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3" type="password" id="input_senha_exemplo" name="password" placeholder="Digite sua senha atual" />
                    <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                      <div class="group-[.error]:hidden">
                        <button type="button" data-inputId="input_senha_exemplo" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                          <img src="/inscricao/images/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                          <img src="/inscricao/images/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                        </button>
                      </div>
                      <div class="hidden group-[.error]:block">
                        <button type="button" data-inputId="input_senha_exemplo" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                          <img src="/inscricao/images/svg/eye-error.svg" alt="" class="hidden group-[.show]:block" />
                          <img src="/inscricao/images/svg/eye-off-error.svg" alt="" class=" block group-[.show]:hidden" />
                        </button>
                      </div>
                    </div>
                    @error('password')
                    <p class="text-input-error text-sm pt-2 hidden group-[.error]:block">{{ $message }}</p>
                    @enderror

                  </div>
                </div>
                <div class="group w-full max-w-[320px]">
                  <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_senha_field">
                    Nova senha:
                  </label>
                  <div class="group relative">
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3" type="password" id="input_nova_senha" name="new_password" placeholder="Digite sua nova senha" />
                    <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                      <div class="group-[.error]:hidden">
                        <button type="button" data-inputId="input_nova_senha" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                          <img src="/inscricao/images/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                          <img src="/inscricao/images/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                        </button>
                      </div>
                      <div class="hidden group-[.error]:block">
                        <button type="button" data-inputId="input_nova_senha" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                          <img src="/inscricao/images/svg/eye-error.svg" alt="" class="hidden group-[.show]:block" />
                          <img src="/inscricao/images/svg/eye-off-error.svg" alt="" class=" block group-[.show]:hidden" />
                        </button>
                      </div>
                    </div>
                    @error('new_password')
                    <p class="text-input-error text-sm pt-2 hidden group-[.error]:block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="group w-full max-w-[320px]">
                  <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="input_nova_senha_confirm">
                    Repita a nova senha:
                  </label>
                  <div class="group relative">
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3" type="password" id="input_nova_senha_confirm" name="confirm_password" placeholder="Reinsira sua nova senha" />
                    <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                      <div class="group-[.error]:hidden">
                        <button type="button" data-inputId="input_nova_senha_confirm" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                          <img src="/inscricao/images/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                          <img src="/inscricao/images/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                        </button>
                      </div>
                      <div class="hidden group-[.error]:block">
                        <button type="button" data-inputId="input_nova_senha_confirm" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                          <img src="/inscricao/images/svg/eye-error.svg" alt="" class="hidden group-[.show]:block" />
                          <img src="/inscricao/images/svg/eye-off-error.svg" alt="" class=" block group-[.show]:hidden" />
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex gap-4 flex-wrap">
                <button type="submit" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
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
