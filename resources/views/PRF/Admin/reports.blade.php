@extends('Admin.base')

@section('title', 'Relatórios - Meia Maratona PRF')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 7]) --}}


  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 5])
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Relatórios
          </h1>
        </header>

        <div class="flex flex-wrap gap-4">
          <div>
            <h2 class="text-lg text-gray-1 font-poppins font-semibold">Vouchers</h2>
            <div class="flex flex-col gap-2">
              <a target="_blank" href="{{route('all_vouchers_get_admin_get')}}" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
                <img src="{{asset('/images/svg/download.svg')}}" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Todos os vouchers
                </p>
              </a>

              <a target="_blank" href="{{route('vouchers_with_user_admin_get')}}" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
                <img src="{{asset('/images/svg/download.svg')}}" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Vouchers usados
                </p>
              </a>
            </div>
          </div>

          <div>
            <h2 class="text-lg text-gray-1 font-poppins font-semibold">Usuários</h2>
            <div class="flex flex-col gap-2">
              <a target="_self" href="{{route('all_users_get_admin_get')}}" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
                <img src="{{asset('/images/svg/download.svg')}}" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Todos os usuários
                </p>
              </a>
            </div>
          </div>


          <div>
            <h2 class="text-lg text-gray-1 font-poppins font-semibold">Inscrições</h2>
            <div class="flex flex-col gap-2">
              <a target="_self" href="{{route('all_confirmed_registrations_admin_get')}}" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
                <img src="{{asset('/images/svg/download.svg')}}" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Inscrições confirmadas
                </p>
              </a>
            </div>
          </div>

          
        </div>
      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="{{asset('/frontend/dist/js/index.js')}}"></script>
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
