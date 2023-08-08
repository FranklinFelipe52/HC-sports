@extends('Admin.base')

@section('title', 'Relatórios - Meia Maratona PRF')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 7]) --}}


  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 3])
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

        <div class="flex gap-4">
          <a href="/admin/all_vouchers_get" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
            <img src="/images/svg/download.svg" alt="">
            <p class="text-white text-sm font-bold font-poppins">
              Todos os vouchers
            </p>
          </a>

          <a href="/admin/vouchers_with_user" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
            <img src="/images/svg/download.svg" alt="">
            <p class="text-white text-sm font-bold font-poppins">
              Vouchers usados
            </p>
          </a>
        </div>

        {{-- <form method="post" action="/admin/reports" class="w-full max-w-[700px]">
          @csrf
          <div class="mb-4">
            <p class="text-gray-1 text-sm">
              Selecione um intervalo
            </p>
          </div>
          <div class="flex gap-4 mb-4">
            <div class="grow">
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="input_date_exemplo">
                Data início
              </label>
              <div class="relative">
                <input class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" min='{{$date_start_min}}' max={{$date_start_max}} type="date" id="cadastro_nascimento_field" name="date_start" />
                <div class="absolute top-4 right-4 bg-white pl-4">
                  <img src="/images/svg/calendar.svg" alt="" />
                </div>
              </div>
            </div>
            <div class="grow">
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="input_date_exemplo">
                Data fim
              </label>
              <div class="relative">
                <input class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition"  min='{{$date_end_min}}' max={{$date_end_max}} type="date" id="cadastro_nascimento_field" name="date_end" />
                <div class="absolute top-4 right-4 bg-white pl-4">
                  <img src="/images/svg/calendar.svg" alt="" />
                </div>
              </div>
            </div>
            <div class="grow">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="select_exemplo">
                UF
              </label>
              <div class="relative">

                <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="uf" id="select_exemplo">
                  <option value selected>Todas UFs</option>
                  @foreach ($federative_units as $federative_unit)
                    <option value="{{ $federative_unit->id }}">{{ $federative_unit->initials }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>
            <div class="grow">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="select_exemplo">
                Situação
              </label>
              <div class="relative">
                <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="status" id="select_exemplo">
                  <option value selected>Todos</option>
                  @foreach ($status as $value)
                    <option value="{{ $value->id }}">{{ $value->status }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>
          </div>
          <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
            <p class="text-gray-1 text-sm font-semibold mb-3">
              Selecione os itens que você deseja exportar no relatório
            </p>
            <div class="flex flex-col gap-3">

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="002" name="colunas[]" id="check-002">
                  <label class="block text-sm" for="check-002">CPF</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="003" name="colunas[]" id="check-003">
                  <label class="block text-sm" for="check-003">Data de nascimento</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="004" name="colunas[]" id="check-004">
                  <label class="block text-sm" for="check-004">Gênero</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="005" name="colunas[]" id="check-005">
                  <label class="block text-sm" for="check-005">E-mail</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="006" name="colunas[]" id="check-006">
                  <label class="block text-sm" for="check-006">Celular</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="007" name="colunas[]" id="check-007">
                  <label class="block text-sm" for="check-007">Cidade</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="008" name="colunas[]" id="check-008">
                  <label class="block text-sm" for="check-008">Estado</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="009" name="colunas[]" id="check-009">
                  <label class="block text-sm" for="check-009">Modalidade</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="010" name="colunas[]" id="check-010">
                  <label class="block text-sm" for="check-010">Faixa</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="011" name="colunas[]" id="check-011">
                  <label class="block text-sm" for="check-011">Categoria</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="012" name="colunas[]" id="check-012">
                  <label class="block text-sm" for="check-012">Subcategoria</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="013" name="colunas[]" id="check-013">
                  <label class="block text-sm" for="check-011">Data de criação</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="014" name="colunas[]" id="check-014">
                  <label class="block text-sm" for="check-014">Tipo de pagamento</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="015" name="colunas[]" id="check-015">
                  <label class="block text-sm" for="check-015">Valor pago</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="016" name="colunas[]" id="check-016">
                  <label class="block text-sm" for="check-016">Status de pagamento</label>
                </div>
              </div>

              <div class="grow">
                <div class="flex items-center gap-2">
                  <input class="checkbox" checked type="checkbox" value="017" name="colunas[]" id="check-017">
                  <label class="block text-sm" for="check-017">PCD</label>
                </div>
              </div>

            </div>
          </div>
          <div class="flex flex-wrap justify-between gap-6">
            <button type="submit" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
              <img src="/images/svg/download.svg" alt="">
              <p class="text-white text-sm font-bold font-poppins">
                Gerar Excel
              </p>
            </button>
          </div>
        </form> --}}
      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/frontend/dist/js/index.js"></script>
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
