@extends('Admin.base')

@section('title', 'Códigos e descontos - Meia Maratona PRF')

@section('content')

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 4])

    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="px-6 h-full w-full flex flex-col overflow-hidden">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 justify-between flex flex-wrap gap-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Códigos e descontos
          </h1>
          <div class="flex items-center justify-center sm:justify-start gap-4 ">
            <a role="button" href="/admin/discounts/new" class="ml-auto px-4 py-2.5 w-fit rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
              <p class="text-white text-sm font-bold font-poppins">
                Novo
              </p>
            </a>
          </div>
        </header>

        <!-- Table container -->
        <div class="h-fit flex flex-col overflow-hidden">

          <!-- Table search bar -->
          <div class="p-4 border border-gray-5 rounded-t-lg">
            <div class="flex gap-2 flex-wrap">
              <form class="relative grow">

                <input type="text" value="{{ request('s') }}" placeholder="Pesquise por um código ou descrição" name="s" class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg pl-12 w-full border border-gray-5 focus:border-brand-prfA1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-prfA1 transition">
                <button type="submit" class="absolute top-[10%] left-3">
                  <img src="/images/svg/search.svg" alt="">
                </button>

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
                    Código
                  </p>
                </div>

                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Tipo
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Desconto
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-2">
                  <p class="text-sm font-semibold text-gray-1 ">
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
              @if (count($vouchers_and_cupons) !== 0)
                @foreach ($vouchers_and_cupons as $voucher_or_cupom)
                  <!-- Table row -->
                  <div role="row" class="border-b border-gray-5 last:border-b-0" data-pagination-item>
                    <div class="grid grid-cols-12 px-6 pt-4 pb-2.5">
                      <div role="cell" class="col-span-3 pr-3">
                        <p class="text-gray-1 text-sm font-semibold text-ellipsis w-full overflow-hidden whitespace-nowrap">
                          {{ $voucher_or_cupom->code }}
                        </p>
                      </div>
                      <div role="cell" class="col-span-3">
                        <p class="text-sm font-semibold text-gray-1">
                          {{ $voucher_or_cupom->isCupom == 1 ? 'Cupom de desconto' : 'Voucher' }}
                        </p>
                      </div>
                      <div role="cell" class="col-span-3 pr-2">
                        <p class="text-gray-1 text-sm font-semibold">
                          {{ $voucher_or_cupom->desconto * 100 }}%
                        </p>
                      </div>
                      <div role="cell" class="col-span-2">
                        @if ($voucher_or_cupom->isCupom)
                          @if ($voucher_or_cupom->validade < now()->format('Y-m-d'))
                            <p class="text-sm font-normal text-[#949699] italic">
                              Expirado
                            </p>
                          @else
                            <p class="text-sm text-feedback-green-2 font-bold">
                              VALENDO
                            </p>
                          @endif
                        @endif

                        @if (!$voucher_or_cupom->isCupom)
                          @if ($voucher_or_cupom->validade < now()->format('Y-m-d'))
                            <p class="text-sm font-normal text-[#949699] italic">
                              Expirado
                            </p>
                          @elseif($voucher_or_cupom->prf_registrations == 0)
                            <p class="text-sm font-normal text-gray-2 italic">
                              Não utlilizado
                            </p>
                          @elseif($voucher_or_cupom->prf_registrations > 0)
                            <p class="text-sm text-gray-2 font-bold">
                              Utilizado
                            </p>
                          @endif
                        @endif
                      </div>
                      <div role="cell" class="col-span-1 flex justify-end">
                        <form action="/admin/discounts/{{ $voucher_or_cupom->id }}/delete" method="POST">
                          @csrf
                          <button class="">
                            <img src="/images/svg/trash.svg" class="h-full w-full object-cover" alt="">
                          </button>
                        </form>
                      </div>
                    </div>
                    <div class="grid grid-cols-12 px-6 pt-2 pb-2 bg-fill-base">
                      <div role="cell" class="col-span-3">
                        <p class="text-sm text-gray-2 italic">
                          validade
                        </p>
                        <p class="text-sm text-gray-1 font-semibold italic">
                          {{ date('d/m/Y', strtotime($voucher_or_cupom->created_at)) }} à {{ date('d/m/Y', strtotime($voucher_or_cupom->validade)) }}
                        </p>
                      </div>
                      <div role="cell" class="col-span-3">
                        <p class="text-sm text-gray-2 italic">
                          descrição
                        </p>
                        <p class="text-sm text-gray-1 font-semibold italic">
                          {{ $voucher_or_cupom->descricao ? $voucher_or_cupom->descricao : '-' }}
                        </p>
                      </div>
                      @if ($voucher_or_cupom->isCupom)
                        <div role="cell" class="col-span-3">
                          <p class="text-sm text-gray-2 italic">
                            Relatório
                          </p>
                          <p class="text-sm text-gray-1 italic font-medium">
                            {{ $voucher_or_cupom->prf_registrations }} utilizações
                          </p>
                        </div>
                      @endif
                    </div>

                  </div>
                @endforeach
              @else
                <div class="py-4">
                  <p class="text-sm text-center text-gray-1">
                    Nenhum código de desconto.
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
              <button data-button="prev-page-button" class="disabled:bg-gray-300 bg-brand-prfA1 bg-a1 px-[5px] py-[2px] rounded hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 disabled:ring-0 transition">
                <img src="/images/svg/chevron-left.svg" alt="">
              </button>
            </div>
            <p class="text-sm text-gray-1 pt-0.5" data-pagination-label></p>
            <div class="group">
              <button data-button="next-page-button" class="disabled:bg-gray-300 bg-brand-prfA1 px-[5px] py-[2px] rounded hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 disabled:ring-0 transition">
                <img src="/images/svg/chevron-right.svg" alt="">
              </button>
            </div>
          </div>


          <div>
            <p class="text-gray-3 text-sm font-normal">
              {{ Count($vouchers_and_cupons) }} Códigos de desconto exibidos
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
