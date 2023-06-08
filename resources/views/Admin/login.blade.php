@extends('Admin.base')

@section('title', 'Login')

@section('content')
  <div class="lg:grid lg:grid-cols-7 xl:container">
    <div class="lg:sticky lg:top-0 lg:h-screen max-h-[1200px] lg:col-span-3 bg-white bg-[url('/images/background.png')] bg-cover bg-no-repeat">
      <div class="flex flex-col h-full">
        <header class="p-5">
          <a href="/admin/login">
            <img src="/images/Olimpiadas-Concad.png" alt="" />
          </a>
        </header>
        <div class="p-8 pb-12 lg:p-8 my-auto">
          <div class="w-fit">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-semibold text-brand-v1 font-poppins">
              Faça login
            </h1>
            <div class="bg-brand-a1 h-1 rounded-lg mt-3.5 mb-2 w-1/2"></div>
          </div>
          <p class="text-sm font-normal text-gray-1">
            Para acessar o seu painel de administrador.
          </p>
        </div>
        <div class="hidden lg:block p-8"></div>
        <div class="mx-auto pb-8 lg:p-0 lg:absolute lg:top-1/2 lg:-right-6 hidden lg:block">
          <a href="#cadastro_formulario" class="bg-dark-400 w-12 h-12 flex justify-center items-center rounded-full rotate-90 lg:rotate-0">
            <img src="/images/svg/chevron-left-fill.svg" alt="" />
          </a>
        </div>
      </div>
    </div>
    <div class="bg-white h-full lg:col-span-4 px-8 py-20  flex flex-col justify-center">
      <div class="mx-auto w-full max-w-[327px]">
        <form id="cadastro_formulario" method="post" class="mb-4">
          @csrf
          <div class="space-y-4 mb-6">
            <div class="group @error('email') error @enderror">
              <div class="relative">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_email_field">
                  E-mail
                </label>
                <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="cadastro_email_field" name="email" placeholder="Digite o seu e-mail" />

                @error('email')
                  <div class="absolute bg-white top-[50%] right-3">
                    <img src="/images/svg/input-error.svg" alt="">
                  </div>
                @enderror
              </div>
              @error('email')
                <p class="text-input-error text-sm pt-2">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_senha_field">
                Senha
              </label>
              <div class="relative group @error('password') error @enderror">
                <input id="input_password_login" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3" type="password" id="cadastro_senha_field" name="password" placeholder="Digite a sua senha" />
                @error('password')
                  <p class="text-input-error text-sm pt-2">{{ $message }}</p>
                @enderror
                <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                  <div>
                    <button type="button" data-inputId="input_password_login" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 hidden group-[.error]:flex justify-center items-center rounded-full group">
                      <img src="/images/svg/eye-error.svg" alt="" class="hidden group-[.show]:block" />
                      <img src="/images/svg/eye-off-error.svg" alt="" class="block group-[.show]:hidden" />
                    </button>
                    <button type="button" data-inputId="input_password_login" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6 transition w-8 h-8 flex group-[.error]:hidden justify-center items-center rounded-full group">
                      <img src="/images/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                      <img src="/images/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <a href="/admin/forgot_password" class="block pb-1 text-sm font-normal text-brand-a1 underline">
              Esqueci minha senha
            </a>
          </div>
          <button id="submit_button" data-conditional-button type="submit" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
            <p class="text-white text-sm font-bold font-poppins">
              Entrar
            </p>
          </button>
        </form>
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
