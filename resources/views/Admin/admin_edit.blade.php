@extends('Admin.base')

@section('title', 'Perfil')


@section('content')

@include('components.admin.menu_mobile', ['type' => 5])

<!-- grid principal -->
<div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

  <!-- Menu lateral -->
  <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
    @include('components.admin.menu_lateral', ['type' => 5]);
  </div>

  <!-- corpo da página -->
  <div class="order-1 sm:order-2 overflow-hidden">
    <div class="h-full w-full flex flex-col overflow-auto pb-8">

      <!-- Cabeçalho -->
      <header class="pt-8 pb-6 space-y-6">
        <div class="container">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
            <div>
              <a target="_self" href="/admin/administradores" class="text-xs text-gray-1 block hover:underline">
                Administradores
              </a>
            </div>
            <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Alterar Perfil
            </div>
          </nav>
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Alterar perfil
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
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_cpf_field">
                      CPF
                    </label>
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cadastro_cpf_field" name="cpf" value="{{$admin->cpf}}" placeholder="Digite o seu CPF" />
                    @error('cpf')
                    <p class="text-input-error text-sm pt-2  group-[.error]:block">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="grow">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_email_field">
                      E-mail
                    </label>
                    <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="cadastro_email_field" name="email" value="{{$admin->email}}" placeholder="Digite o seu E-mail" />
                    @error('email')
                    <p class="text-input-error text-sm pt-2  group-[.error]:block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div>
                  <label class="text-gray-1 font-semibold text-base block mb-2" for="cadastro_nome_completo_field">
                    Nome completo
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full max-w-[321px] px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cadastro_nome_completo_field" name="nome" value="{{$admin->nome_completo}}" onkeyup="this.value = this.value.toUpperCase();" placeholder="Digite o seu nome completo" />
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
