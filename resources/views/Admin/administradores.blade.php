@extends('Admin.base')

@section('title', 'Administradores')
@section('administradoresClass', 'active')

@section('content')

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">


    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral',  ['type'=>2]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="px-6 h-full w-full flex flex-col overflow-hidden">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 flex flex-wrap gap-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Administradores Cadastrados
          </h1>
          <a role="button" href="/admin/administradores/create" class="ml-auto flex items-center justify-center sm:justify-start gap-4 w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
            <p class="text-white text-sm font-bold font-poppins">
              Cadastrar Gerente
            </p>
          </a>
        </header>

        <!-- Table container -->
        <div class="h-fit flex flex-col overflow-hidden">

          <!-- Table search bar -->
          <div class="p-4 bg-gray-6 border border-gray-5 rounded-t-lg">
            <div class="flex gap-2 flex-wrap">
              <form class="relative grow">

                <input type="text" placeholder="Pesquise por um atleta usando cpf ou nome" name="s" class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg pl-12 w-full border border-gray-5 focus:border-brand-a1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-a1 transition">
                <button type="submit" class="absolute top-[14%] left-3 bg-white">
                  <img src="/images/svg/search.svg" alt="">
                </button>

              </form>
              @if (Session('admin')->rule->id == 1)
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
                <div role="columnheader" class="text-start col-span-4">
                  <p class="text-sm font-semibold text-gray-1">
                    Nome
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1 ">
                    UF
                  </p>
                </div>
                <div role="columnheader" class="opacity-0 col-span-2 text-end">
                  <p class="text-sm font-semibold text-gray-1">
                    Ações
                  </p>
                </div>
              </div>
            </div>

            <!-- Table body -->
            <div class="min-w-[600px] h-fit overflow-auto border border-t-0 border-gray-5 rounded-b-lg">
              @foreach ($administradores as $administrador)
                <!-- Table row -->
                <div role="row" class="px-4 grid grid-cols-12 border-b border-b-gray-5 last:border-b-0">
                  <div role="cell" class="py-3 flex items-center col-span-3">
                    <p class="text-sm font-semibold text-gray-2">
                      <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $administrador->cpf); ?>
                    </p>
                  </div>
                  <div role="cell" class="pr-2 py-3 flex items-center col-span-4">
                    <p class="text-sm font-semibold text-gray-2">
                      {{ $administrador->nome_completo }}
                    </p>
                  </div>
                  <div role="cell" class="py-3 flex items-center col-span-3">
                    <p class="text-sm font-semibold text-gray-2">
                      @if (Session('admin')->rule->id == 1)
                        -
                      @else
                        {{ $administrador->federative_unit_name }}
                      @endif
                    </p>
                  </div>
                  <div role="cell" class="py-3 flex gap-2 justify-end items-center col-span-2">
                    <a href="#" class="w-[34px] h-[34px] hover:bg-fill-base hover:ring-2 hover:ring-fill-base rounded-full transition">
                      <img src="/images/svg/pencil-outline-disabled.svg" class="h-full w-full object-cover" alt="">
                    </a>
                    <a href="#" class="w-[34px] h-[34px] hover:bg-fill-base hover:ring-2 hover:ring-fill-base rounded-full transition">
                      <img src="/images/svg/ficha.svg" class="h-full w-full object-cover" alt="">
                    </a>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        </div>

        <!-- Paginação da tabela -->
        <div class="flex justify-between pt-6 pb-4 sm:pb-16">
          {{ $administradores->appends([
                  's' => request()->get('s', ''),
                  'uf' => request()->get('uf', ''),
              ])->links() }}
          <div>
            <p class="text-gray-3 text-sm font-normal">
              @if (Count($administradores) > 1)
                {{ Count($administradores) }} Administradores exibidos
              @else
                {{ Count($administradores) }} Administrador exibido
              @endif

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
