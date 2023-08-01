@extends('PRF.base')

@section('title', 'Vouchers Relatorio - Meia Maratona PRF')

@section('content')

  <div class="lg:grid lg:grid-cols-7 xl:container">
    <div class="lg:sticky lg:top-0 lg:h-screen max-h-[1200px] lg:col-span-3 bg-white bg-[url('/images/PRF/background.png')] bg-cover bg-no-repeat">
      <div class="flex flex-col h-full">
        <header class="p-5">
          <a href="/">
            <img src="/images/PRF/Logo-Meia-PRF.png" class="h-[100px]"  alt="" />
          </a>
        </header>
        <div class="p-8 pb-12 lg:p-8 my-auto">
          <div class="w-fit">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-semibold text-brand-prfA1 font-poppins">
                Vauchers relatorio
            </h1>
            <div class="bg-brand-prfA1 h-1 rounded-lg mt-3.5 mb-2 w-1/2"></div>
          </div>
          {{-- <p class="text-sm font-normal text-gray-1">
            Gere cupoms
          </p> --}}
        </div>
        <div class="hidden lg:block p-8"></div>
        <div class="mx-auto pb-8 lg:p-0 lg:absolute lg:top-1/2 lg:-right-6 hidden lg:block">
          <a href="#gerar_cupom_form" class="bg-dark-400 w-12 h-12 flex justify-center items-center rounded-full rotate-90 lg:rotate-0">
            <img src="/images/svg/chevron-left-fill.svg" alt="" />
          </a>
        </div>
      </div>
    </div>
    <div class="bg-white h-full lg:col-span-4 px-8 py-20  flex flex-col justify-center">
      <div class="mx-auto w-full flex flex-col gap-4 max-w-[327px]">
          <a href="/admin/all_vauchers_get" target="_blank" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
            <p class="text-white text-sm font-bold font-poppins">
              Todos os Vauchers
            </p>
          </a>
          <a href="/admin/vauchers_with_user" target="_blank" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
            <p class="text-white text-sm font-bold font-poppins">
              Vauchers usados
            </p>
          </a>
      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/js/app.js"></script>
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
  </script>
@endsection
