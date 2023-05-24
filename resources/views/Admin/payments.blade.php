@extends('Admin.base')

@section('title', 'Perfil')

@section('content')

  @if (count($payments) !== 0)
    @foreach ($payments as $payment)
      {{-- modal validar inscrição --}}
      <div id="modal-confirmar-pagamento-{{ $payment->id }}" class="hidden">
        <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
          <div class="bg-white mx-3 p-3 md:p-6 rounded-lg w-full max-w-[500px]">
            <!-- modal header -->
            <div class="text-gray-1 text-lg md:text-xl font-semibold">
              <p>
                Confirmar pagamento de Inscrição
              </p>
            </div>
            <hr class="my-4">

            <!-- modal body -->
            <div class="text-gray-1 text-base">
              <p>
                Confirme se realmente deseja validar essa inscrição
              </p>
            </div>

            <!-- modal footer - actions -->
            <div class="flex justify-end gap-4 flex-wrap mt-10">
              <button data-modalId="modal-confirmar-pagamento-{{ $payment->id }}" data-action="close" class="bg-white border border-black text-v1 text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-gray-4 hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0">
                Cancelar
              </button>
              <a href="/admin/pagamentos/confirm/{{ $payment->id }}" class="bg-brand-a1 border border-brand-a1 text-white text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-v1 hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0">
                Validar
              </a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @endif

  @include('components.admin.menu_mobile', ['type' => 6])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">
    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 6]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('admin')->personification)
        @include('components.admin.personification_nav')
      @endif
      <!-- administrador personificado -->
      <div class="hidden bg-brand-a1 py-2 px-4 lg:px-6">
        <div class="flex">
          <button class="text-xs font-poppins text-white border border-white py-0.5 px-2 ml-auto hover:ring-1 hover:ring-white hover:ring-opacity-50 transition">
            Mudar para administrador
          </button>
        </div>
      </div>

      <div class="px-6 h-full w-full flex flex-col overflow-hidden">
        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 flex flex-wrap">
          <div class="grow">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Pagamentos Pendentes
            </h1>
          </div>
        </header>
        @if (session('erro'))
          <div class="group error w-full">
            <div class="flex items-center gap-8 px-4 py-3 rounded group-[.success]:bg-alert-success-fill group-[.error]:bg-alert-error-fill group-[.error]:text-alert-error-base group-[.success]:text-alert-success-base">
              <div class="grow">
                <p class="text-sm">
                  {{ session('erro') }}
                </p>
              </div>
            </div>
          </div>
        @endif

        @if (session('success'))
          <div class="group  w-full">
            <div class="flex items-center gap-8 px-4 py-3 rounded group-[.success]:bg-alert-success-fill group-[.error]:bg-alert-error-fill group-[.error]:text-alert-error-base group-[.success]:text-alert-success-base">
              <div class="grow">
                <p class="text-sm">
                  {{ session('success') }}
                </p>
              </div>
            </div>
          </div>
        @endif
        <!-- Table container -->
        <div class="h-fit flex flex-col overflow-hidden">

          <!-- Table search bar -->
          <div class="p-4 border border-gray-5 rounded-t-lg">
            <div class="flex gap-2 flex-wrap">


              <form class="relative grow">

                <input type="text" value="{{ request('s') }}" placeholder="Pesquise por um pagamento usando o nome" name="s" class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg pl-12 w-full border border-gray-5 focus:border-brand-a1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-a1 transition">
                <button type="submit" class="absolute top-[10%] left-3">
                  <img src="/images/svg/search.svg" alt="">
                </button>

              </form>
              <form id="filter_status" class="relative">
                <select onchange="document.getElementById('filter_status').submit()" class="w-full min-w-[195px] px-4 py-2 rounded-lg bg-white border border-gray-5 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 text-sm placeholder:text-gray-3 appearance-none" name="status">
                  <option value disabled selected>Status</option>
                  @foreach ($status_payments as $status)
                    <option {{ Request::get('status') && Request::get('status') == $status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->status }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>

              </form>
            </div>
          </div>

          <!-- Table -->
          <div class="h-fit flex flex-col overflow-y-hidden overflow-x-auto" role="table">
            <!-- Table header -->
            <div class="border-x border-b bg-gray-6 border-gray-5 min-w-[700px]" role="heading">
              <div role="row" class="px-6 grid grid-cols-12 py-3">
                <div role="columnheader" class="col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    Atleta
                  </p>
                </div>

                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Modalidade
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-2">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Valor
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    Status
                  </p>
                </div>
                <div role="columnheader" class="col-span-1 flex justify-end">
                  <p class="text-sm font-semibold text-gray-1">
                    Ações
                  </p>
                </div>
              </div>
            </div>

            <!-- Table body -->
            <div class="min-w-[700px] h-fit overflow-auto border border-t-0 border-gray-5 rounded-b-lg" data-pagination>
              @if (count($payments) !== 0)
                @foreach ($payments as $payment)
                  <!-- Table row -->
                  <div role="row" class="border-b border-gray-5 last:border-b-0" data-pagination-item>
                    <div class="grid grid-cols-12 px-6 pt-4 pb-2.5">
                      <div role="cell" class="col-span-3 pr-3">
                        <p class="text-gray-1 text-sm font-semibold text-ellipsis w-full overflow-hidden whitespace-nowrap">
                          @if ($payment->nome_completo)
                            {{ $payment->nome_completo }}
                          @else
                            -
                          @endif
                        </p>
                      </div>
                      <div role="cell" class="col-span-3">
                        <p class="text-sm font-semibold text-gray-1">
                          {{ $payment->modalidade_nome }}
                        </p>
                      </div>
                      <div role="cell" class="col-span-2 pr-2">
                        <p class="text-gray-1 text-sm font-semibold">
                          @if ($payment->mount)
                            <?php echo "R$ " . number_format($payment->mount, 2, ',', ''); ?>
                          @else
                            -
                          @endif
                        </p>
                      </div>
                      <div role="cell" class="col-span-2">
                        <p class="text-sm font-normal text-gray-2">
                          {{ $payment->status }}
                        </p>
                      </div>
                      <div role="cell" class="col-span-2 flex justify-end">
                      @if ( Session('admin')->rule->id == 1 && !Session('admin')->personification)
                          <button data-modalId="modal-confirmar-pagamento-{{ $payment->id }}" data-action="open" data-tooltip-payment class="block w-[24px] h-[24px] hover:bg-fill-base hover:ring-2 hover:ring-fill-base rounded-full transition">
                          <img src="/images/svg/pagamentos.svg" class="h-full w-full object-cover" alt="">
                        </button>
                      @endif

                      </div>
                    </div>
                    <div class="grid grid-cols-12 px-6 pt-2 pb-2 bg-fill-base">
                      <div role="cell" class="col-span-3">
                        <p class="text-sm text-gray-2 italic">
                          id payment
                        </p>
                        <p class="text-sm text-gray-2 italic">
                          #
                          @if ($payment->id_payment)
                            {{ $payment->id_payment }}
                          @else
                            -
                          @endif
                        </p>
                      </div>
                      <div role="cell" class="col-span-3">
                        <p class="text-sm text-gray-2 italic">
                          date
                        </p>
                        <p class="text-sm text-gray-2 italic">

                          @if ($payment->updated_at)
                            {{ date('d/m/Y H:i:s', strtotime($payment->updated_at)) }}
                          @else
                            -
                          @endif
                        </p>
                      </div>
                    </div>

                  </div>
                @endforeach
              @else
                <div class="py-4">
                  <p class="text-sm text-center text-gray-1">
                    Nenhum pagamento.
                  </p>
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Paginação da tabela -->
        <div class="flex justify-between pt-6 pb-4 sm:pb-16">

          <div class="flex gap-2" aria-label="Paginação da tabela" data-pagination-buttons>
            <div class="group">
              <button data-button="prev-page-button" class="disabled:bg-gray-300 bg-brand-a1 bg-a1 px-[5px] py-[2px] rounded hover:ring-2 hover:ring-a1 hover:ring-opacity-50 disabled:ring-0 transition">
                <img src="/images/svg/chevron-left.svg" alt="">
              </button>
            </div>
            <p class="text-sm text-gray-1 pt-0.5" data-pagination-label></p>
            <div class="group">
              <button data-button="next-page-button" class="disabled:bg-gray-300 bg-brand-a1 px-[5px] py-[2px] rounded hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 disabled:ring-0 transition">
                <img src="/images/svg/chevron-right.svg" alt="">
              </button>
            </div>
          </div>

          <div>
            <p class="text-gray-3 text-sm font-normal">
              {{ Count($payments) }} pagamentos
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- js -->
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <script src="https://unpkg.com/tippy.js@6"></script>

  <script>
    // With the above scripts loaded, you can call `tippy()` with a CSS
    // selector and a `content` prop:
    tippy('[data-tooltip-payment]', {
      content: 'Confirmar o pagamento',
      placement: 'top'
    });

    const paginationList = document.querySelector('[data-pagination]');
    const paginationListItem = Array.from(document.querySelectorAll('[data-pagination-item]'));
    const prevPageButton = document.querySelector('[data-button="prev-page-button"]');
    const nextPageButton = document.querySelector('[data-button="next-page-button"]');
    const paginationLabel = document.querySelector('[data-pagination-label]');
    const paginationButtons = document.querySelector('[data-pagination-buttons]');

    let currentPage = 1;
    let itemsPerPage = 8;
    let totalItems = paginationListItem.length;
    let totalPages = Math.ceil(paginationListItem.length / itemsPerPage);

    paginationListItem.forEach(item => {
      item.classList.add('hidden');
    })

    prevPageButton.addEventListener('click', prevPage);
    nextPageButton.addEventListener('click', nextPage);

    function prevPage() {

      if (currentPage == 1) return;

      currentPage--;
      displayCurrentPage(currentPage, itemsPerPage, totalItems);
    }

    function nextPage() {

      if (currentPage == totalPages) return;

      currentPage++;
      displayCurrentPage(currentPage, itemsPerPage, totalItems);
    }

    function displayCurrentPage(currentPage, itemsPerPage, totalItems) {

      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

      // Exibe apenas os itens correspondentes à página atual
      for (let i = 0; i < totalItems; i++) {
        if (i >= startIndex && i < endIndex) {
          paginationListItem[i].classList.remove('hidden');
        } else {
          paginationListItem[i].classList.add('hidden');
        }
      }

      paginationLabel.innerHTML = `${currentPage} de ${totalPages}`;

      if (currentPage == 1) {
        prevPageButton.disabled = true;
      } else {
        prevPageButton.disabled = false;
      }

      if (currentPage == totalPages) {
        nextPageButton.disabled = true;
      } else {
        nextPageButton.disabled = false;
      }

      if (totalItems === 0) {
        paginationButtons.classList.add('hidden');
      }

    }

    displayCurrentPage(currentPage, itemsPerPage, totalItems);
  </script>
@endsection
