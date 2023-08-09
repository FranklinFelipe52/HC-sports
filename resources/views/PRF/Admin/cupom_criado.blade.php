@extends('Admin.base')

@section('title', 'Cupom criado - Meia Maratona PRF')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 1]) --}}

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 4])
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/admin/discounts" class="text-xs text-gray-1 block hover:underline">
                Códigos e descontodos
              </a>
            </div>
            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
              Cadastro de código
            </div>
          </nav>
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Cupom criado!
          </h1>
        </header>

        <div class="w-full max-w-[200px]">
          <div class="mb-4">
            <div class="space-y-4 mb-6">
              <div class="group @error('descricao') error @enderror">
                <div class="relative">
                  <input disabled value="{{ $cupom }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="cupom_field" name="cupom" placeholder="Código do cupom" />
                </div>
              </div>
            </div>
            <button id="copiar_button" onclick="copiarCupom()" type="submit" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
              <p class="text-white text-sm font-bold font-poppins">
                Copiar cupom
              </p>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
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

    function copiarCupom() {
      const cupomValue = document.getElementById("cupom_field").value;

      const tempInput = document.createElement("textarea");
      tempInput.value = cupomValue;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      showSuccessToastfy("Cupom copiado para a área de transferência");
    }
  </script>
@endsection


@extends('PRF.base')

@section('title', 'Cupom criado - Meia Maratona PRF')

@section('content')

  <div class="lg:grid lg:grid-cols-7 xl:container">
    <div class="lg:sticky lg:top-0 lg:h-screen max-h-[1200px] lg:col-span-3 bg-white bg-[url('/images/PRF/background.png')] bg-cover bg-no-repeat">
      <div class="flex flex-col h-full">
        <header class="p-5">
          <a href="/admin/dashboard">
            <img src="/images/PRF/Logo-Meia-PRF.png" class="h-[100px]" alt="" />
          </a>
        </header>
        <div class="p-8 pb-12 lg:p-8 my-auto">
          <div class="w-fit">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-semibold text-brand-prfA1 font-poppins">
              Cupom criado!
            </h1>
            <div class="bg-brand-prfA1 h-1 rounded-lg mt-3.5 mb-2 w-1/2"></div>
          </div>
          <p class="text-sm font-normal text-gray-1">
            Agora você pode copiar o cupom criado
          </p>
        </div>
        <div class="hidden lg:block p-8"></div>
        <div class="mx-auto pb-8 lg:p-0 lg:absolute lg:top-1/2 lg:-right-6 hidden lg:block">
          <div class="bg-dark-400 w-12 h-12 flex justify-center items-center rounded-full rotate-90 lg:rotate-0">
            <img src="/images/svg/chevron-left-fill.svg" alt="" />
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white h-full lg:col-span-4 px-8 py-20  flex flex-col justify-center">
      <div class="mx-auto w-full max-w-[327px]">

      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/js/app.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    function copiarCupom() {
      const cupomValue = document.getElementById("cupom_field").value;

      const tempInput = document.createElement("textarea");
      tempInput.value = cupomValue;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      showSuccessToastfy("Cupom copiado para a área de transferência");
    }

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
  </script>
@endsection