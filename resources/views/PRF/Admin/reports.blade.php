@extends('Admin.base')

@section('title', 'Relatórios - Circuito Dunas 2026')

@section('content')

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
        <header class="pt-8 pb-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Relatórios
          </h1>
        </header>

        <div class="flex flex-wrap gap-8">

          <div>
            <h2 class="text-base text-gray-1 font-poppins font-semibold mb-3">Atletas</h2>
            <div class="flex flex-col gap-2">
              <a href="/admin/all_users_get" class="flex items-center justify-start gap-3 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
                <img src="/images/svg/download.svg" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Todos os atletas
                </p>
              </a>
            </div>
          </div>


</div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('erro') }}') {
      Toastify({
        text: '{{ session('erro') }}',
        duration: 3000, gravity: 'top', close: true, position: 'right',
        style: { background: '#FBDBDB', color: '#8E1014', boxShadow: 'none' },
      }).showToast();
    }
    if ('{{ session('success') }}') {
      Toastify({
        text: '{{ session('success') }}',
        duration: 3000, gravity: 'top', close: true, position: 'right',
        style: { background: '#EBFBEE', color: '#279424', boxShadow: 'none' },
      }).showToast();
    }
  </script>

@endsection
