@extends('Admin.base')

@section('title', 'Modalidades')

@section('content')

  @include('components.admin.menu_mobile', ['type' => 3])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type'=> 3]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
    @if(Session('admin')->personification)
    @include('components.admin.personification_nav')
    @endif
      <div class="px-6 h-full w-full flex flex-col overflow-hidden">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Modalidades
          </h1>
        </header>

        <!-- Table container -->
        <div class="h-fit flex flex-col overflow-hidden">

          <!-- Table search bar -->
          <div class="p-4 bg-gray-6 border border-gray-5 rounded-t-lg">
            {{-- <form class="flex gap-2 flex-wrap">
              <div class="relative w-full grow max-w-[400px] md:w-auto">
                <input type="text" placeholder="Pesquise por uma modalidade" class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg pl-12 w-full border border-gray-5 focus:border-brand-a1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-a1 transition">
                <button class="absolute top-[14%] left-3 bg-white">
                  <img src="/images/svg/search.svg" alt="">
                </button>
              </div>
              <div class="relative">
                <select class="w-full min-w-[195px] px-4 py-2 rounded-lg bg-white border border-gray-5 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 text-sm placeholder:text-gray-3 appearance-none" name="filtro_modalidades_page" id="filtro_modalidades_page">
                  <option value="" selected disabled>
                    Filtrar por categoria
                  </option>
                  <option value="">Individual</option>
                  <option value="">Coletiva</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </form> --}}
          </div>

          <!-- Table -->
          <div class="h-fit flex flex-col overflow-y-hidden overflow-x-auto" role="table">
            <!-- Table header -->
            <div class="border-x border-b border-gray-5 min-w-[600px]" role="heading">
              <div role="row" class="grid grid-cols-12 pr-12 py-3">
                <div role="columnheader" class="opacity-0 col-span-2 lg:col-span-1">
                  <p class="text-sm font-semibold text-gray-1">
                    Ícones
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-4 lg:col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    Modalidade
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-2 lg:col-span-3">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Categoria
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-3 lg:col-span-2">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Ocupação Geral
                  </p>
                </div>
                <div role="columnheader" class="opacity-0 text-end col-span-1 lg:col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    Ações
                  </p>
                </div>
              </div>
            </div>

            <!-- Table body -->
            <div class="min-w-[600px] h-fit overflow-auto border border-t-0 border-gray-5 rounded-b-lg">
              <!-- Table row -->
              @foreach ($modalidades as $modalidade)
                <div role="row" class="pr-12 grid grid-cols-12 border-b border-b-gray-5 last:border-b-0">
                  <div role="cell" class="col-span-2 lg:col-span-1 py-3 flex justify-center items-center ">
                    <div class="h-[24px] w-[24px]">
                      <img src="/images/svg/modalidades/modalidade-{{ $modalidade->id }}.svg" alt="" class="h-full w-full object-cover">
                    </div>
                  </div>
                  <div role="cell" class="col-span-4 lg:col-span-3 py-3 flex items-center">
                    <p class="text-sm font-semibold text-gray-600">
                      {{ $modalidade->nome }}
                    </p>
                  </div>
                  <div role="cell" class="col-span-2 lg:col-span-3 py-3 flex items-center">
                    <div class="@if ($modalidade->modalities_type->id == 1) bg-feedback-fill-blue  @else bg-feedback-fill-purple @endif py-1 px-1.5 rounded-full inline-block w-fit h-fit">

                      <p class=" @if ($modalidade->modalities_type->id == 1) text-brand-a1  @else text-feedback-purple @endif     text-sm">
                        {{ $modalidade->modalities_type->type }}
                      </p>
                    </div>
                  </div>
                  <div role="cell" class="col-span-3 lg:col-span-2 py-3 flex items-center">
                    <p class="text-sm font-semibold text-gray-600">
                      @if (Session('admin')->rule->id == 1)

                      @if(Session('admin')->personification)
                      <?php
                      $users_registrations = 0;

                      foreach ($modalidade->registrations as $registration) {
                              if ($registration->user->address->federative_unit_id == Session('admin')->personification ) {
                                $users_registrations++;
                              }
                      }
                      ?>
                      {{ $users_registrations }} inscrições

                      @else
                      {{ Count($modalidade->registrations) }} inscrições
                      @endif

                      @else
                      <?php
                      $users_registrations = 0;

                      foreach ($modalidade->registrations as $registration) {
                              if ($registration->user->address->federative_unit_id == Session('admin')->federative_unit_id ) {
                                $users_registrations++;
                              }
                      }

                      ?>
                      {{ $users_registrations }} inscrições
                      @endif
                    </p>
                  </div>
                  <div role="cell" class="col-span-1 lg:col-span-3 py-3 flex gap-2 justify-end items-center">
                    <a href="/admin/modalidade/{{ $modalidade->id }}" class="w-[34px] h-[34px] hover:bg-fill-base hover:ring-2 hover:ring-fill-base rounded-full transition">
                      <img src="/images/svg/ficha.svg" class="h-full w-full object-cover" alt="">
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- modalidades exibidas -->
        <div class="flex justify-end pt-6 pb-4 sm:pb-16">
          <div>
            <p class="text-gray-3 text-sm font-normal">
              {{ Count($modalidades) }} Modalidades exibidas
            </p>
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
