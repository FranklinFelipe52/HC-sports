@extends('Admin.base')

@section('title', 'Atletas')

@section('content')

  @include('components.admin.menu_mobile', ['type' => 4])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 4]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('admin')->personification)
        @include('components.admin.personification_nav')
      @endif
      <div class="px-6 h-full w-full flex flex-col overflow-hidden">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Atletas Participantes
          </h1>
        </header>

        <!-- Table container -->
        <div class="h-fit flex flex-col overflow-hidden">

          <!-- Table search bar -->
          <div class="p-4 bg-gray-6 border border-gray-5 rounded-t-lg">
            <div class="flex gap-2 flex-wrap">
              <form class="relative grow">

                <input type="text" value="{{ request('s') }}" placeholder="Pesquise por um atleta usando cpf ou nome" name="s" class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg pl-12 w-full border border-gray-5 focus:border-brand-a1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-a1 transition">
                <button type="submit" class="absolute top-[10%] left-3">
                  <img src="/images/svg/search.svg" alt="">
                </button>

              </form>
              @if (Session('admin')->rule->id == 1 && !Session('admin')->personification)

                <form id="filter_uf" class="relative">
                  <select onchange="document.getElementById('filter_uf').submit()" class="w-full min-w-[195px] px-4 py-2 rounded-lg bg-white border border-gray-5 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 text-sm placeholder:text-gray-3 appearance-none" name="uf" id="filtro_atletas_page">
                    <option value disabled selected>UF</option>
                    @foreach ($federative_units as $federative_unit)
                      <option {{ Request::get('uf') && Request::get('uf') == $federative_unit->id ? 'selected' : '' }} value="{{ $federative_unit->id }}">{{ $federative_unit->initials }}</option>
                    @endforeach
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>

                </form>
              @endif

            </div>
          </div>

          <!-- Table -->
          <div class="h-fit flex flex-col overflow-y-hidden overflow-x-auto" role="table">
            <!-- Table header -->
            <div class="border-x border-b border-gray-5 min-w-[600px]" role="heading">
              <div role="row" class="grid grid-cols-12 px-4 py-3">
                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    CPF
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    Nome
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-2">
                  <p class="text-sm font-semibold text-gray-1 ">
                    UF
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-2">
                  <p class="text-sm font-semibold text-gray-1 ">
                    Inscrições
                  </p>
                </div>
                <div role="columnheader" class="opacity-0 col-span-1 text-end">
                  <p class="text-sm font-semibold text-gray-1">
                    Ação
                  </p>
                </div>
              </div>
            </div>

            <!-- Table body -->
            <div class="min-w-[600px] h-fit overflow-auto border border-t-0 border-gray-5 rounded-b-lg" data-pagination>
              @if (count($atletas) !== 0)
                @foreach ($atletas as $atleta)
                  <!-- Table row -->
                  <div role="row" class="px-4 grid grid-cols-12 border-b border-b-gray-5 last:border-b-0" data-pagination-item>
                    <div role="cell" class="py-3 flex items-center col-span-3">
                      <p class="text-sm font-semibold text-gray-2">
                        <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $atleta->cpf); ?>
                      </p>
                    </div>
                    <div role="cell" class="pr-2 py-3 flex items-center col-span-3">
                      <p class="text-sm font-semibold text-gray-2">
                        @if ($atleta->nome_completo == null)
                          -
                        @else
                          {{ $atleta->nome_completo }}
                        @endif
                      </p>
                    </div>
                    <div role="cell" class="py-3 flex items-center col-span-2">
                      <p class="text-sm font-semibold text-gray-2">
                        {{ $atleta->federative_unit_name }}
                      </p>
                    </div>
                    <div role="cell" class="py-3 flex items-center col-span-2">
                      <p class="text-sm font-semibold text-gray-2">
                        {{ Count(App\Models\User::find($atleta->id)->registrations) }}
                      </p>
                    </div>
                    <div role="cell" class="py-3 flex gap-2 justify-end items-center col-span-1">

                      <a href="/admin/users/{{ $atleta->id }}" class="w-[34px] h-[34px] hover:bg-fill-base hover:ring-2 hover:ring-fill-base rounded-full transition">
                        <img src="/images/svg/ficha.svg" class="h-full w-full object-cover" alt="">
                      </a>
                    </div>
                  </div>
                @endforeach
              @else
                <div class="bg-feedback-fill-blue p-4" role="alert">
                  <p class="text-brand-a1">Nenhum atleta cadastrado.</p>
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
              {{ Count($atletas) }} Atletas exibidos
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
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
