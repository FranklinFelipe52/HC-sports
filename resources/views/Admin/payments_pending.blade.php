
@extends('Admin.base')

@section('title', 'Perfil')

@section('content')


  
  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">
    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 6]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
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
            <form class="flex gap-2 flex-wrap sm:flex-nowrap">
              <div class="relative w-full max-w-[478px] grow md:w-auto">
                <input type="text" name="s" placeholder="Pesquise pelo número do pagamento" class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg pl-12 w-full border border-gray-5 focus:border-brand-a1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-a1 transition">
                <button type="submit" class="absolute top-[9%] left-3">
                  <img src="/images/svg/search.svg" alt="">
                </button>
              </div>
            </form>
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
                    Data
                  </p>
                </div>
                <div role="columnheader" class="text-start col-span-3">
                  <p class="text-sm font-semibold text-gray-1">
                    Horário
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
            <div class="min-w-[700px] h-fit overflow-auto border border-t-0 border-gray-5 rounded-b-lg">
              @foreach ($logs as $log)
                  
              
              <!-- Table row -->
              <div role="row" class="border-b border-gray-5 last:border-b-0">
                <div class="grid grid-cols-12 px-6 pt-4 pb-2.5">
                  <div role="cell" class="col-span-3 pr-3">
                    <p class="text-gray-1 text-sm font-semibold text-ellipsis w-full overflow-hidden whitespace-nowrap">
                      {{$log->registration->user->nome_completo}}
                    </p>
                  </div>
                  <div role="cell" class="col-span-3">
                    <p class="text-sm font-semibold text-gray-1">
                      {{$log->registration->modalities->nome}}
                    </p>
                  </div>
                  <div role="cell" class="col-span-2 pr-2">
                    <p class="text-gray-1 text-sm font-semibold">
                      <?php  echo date("d/m/y", strtotime($log->created_at))?>
                    </p>
                  </div>
                  <div role="cell" class="col-span-2">
                    <p class="text-sm font-normal text-gray-2">
                      <?php  echo date("H:i", strtotime($log->created_at))?>
                    </p>
                  </div>
                  <div role="cell" class="col-span-2 flex justify-end">
                    <a href="/admin/pagamentos/confirm/{{$log->id}}" data-tooltip-payment class="block w-[24px] h-[24px] hover:bg-fill-base hover:ring-2 hover:ring-fill-base rounded-full transition">
                      <img src="/images/svg/pagamentos.svg" class="h-full w-full object-cover" alt="">
                    </a>
                  </div>
                </div>
                <div class="grid grid-cols-12 px-6 pt-2 pb-2 bg-fill-base">
                  <div role="cell" class="col-span-3 pr-3">
                    <p class="text-sm text-gray-2 italic">
                      id transaction
                    </p>
                    <p class="text-sm text-gray-2 italic">
                      #{{$log->id_transaction}}
                    </p>
                  </div>
                  <div role="cell" class="col-span-3">
                    <p class="text-sm text-gray-2 italic">
                      id payment
                    </p>
                    <p class="text-sm text-gray-2 italic">
                      #{{$log->id_payment}}
                    </p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Paginação da tabela -->
        <div class="flex justify-between pt-6 pb-4 sm:pb-16">
          {{ $logs->appends([
            's' => request()->get('s', '')
        ])->links() }}
          <div>
            <p class="text-gray-3 text-sm font-normal">
              {{ Count($logs) }} Atletas exibidos
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
  </script>
@endsection
 