@extends('Admin.base')

@section('title', 'Dashboard')

@section('content')
  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 1]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="px-6 h-full w-full grid lg:gap-8 grid-cols-1 lg:grid-cols-6 xl:grid-cols-5 grid-rows-2">
        <div class="lg:row-span-2 lg:col-span-3 xl:col-span-2 flex flex-col overflow-hidden lg:border-r border-gray-5">
          <header class="pt-8 pb-6 border-b-[2px] border-gray-4">
            <h2 class="text-gray-1 text-lg font-semibold font-poppins">
              Atualizações
            </h2>
          </header>

          <div class="grow overflow-hidden relative flex flex-col scroll-fade">
            <!-- lista de atualizações -->
            <ul class="grow overflow-auto pt-4 pb-8 space-y-6 w-full pr-4">

              <!-- atualização
                    <li class="flex flex-wrap gap-4 sm:gap-2 xl:gap-4 items-start pb-6 border-b border-gray-200 hover:bg-fill-base transition w-full">
                    <div class="flex-shrink-0 w-[37px] h-[37px] my-auto overflow-hidden hidden min-[360px]:block">
                        <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
                    </div>
                    <div class="grow space-y-1">
                        <p class="text-base text-gray-1 font-semibold">Jefferson Twawan Silva</p>
                        <p class="text-xs text-gray-1 font-normal">Validou inscrição no atletismo</p>
                    </div>
                    <div class="flex gap-2.5">
                        <div class="ml-auto bg-feedback-fill-green py-1 px-1.5 rounded-full inline-block w-fit h-fit">
                        <p class="text-feedback-green-1 text-xs">
                            Confirmado
                        </p>
                        </div>
                        <p class="text-xs text-gray-600 font-normal">1h</p>
                    </div>
                    </li>-->
            </ul>
          </div>
        </div>
        <div class="row-span-1 lg:row-span-2 lg:col-span-3 flex flex-col overflow-hidden lg:border-r border-gray-5">
          <header class="pt-8 pb-6 border-b-[2px] border-gray-4">
            <h2 class="text-gray-1 text-lg font-semibold font-poppins">
              Modalidades
            </h2>
          </header>

          <div class="overflow-hidden flex flex-col relative scroll-fade">
            <!-- grid de modalidades -->
            <div class="pt-4 pb-8 pr-4 overflow-auto grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
              @foreach ($modalidades as $modalidade)
                <!-- modalidade - item do grid -->
                <div class="space-y-8 p-4 border border-gray-5 rounded-lg">
                  <div class="flex justify-between">
                    <div>
                      <div class="flex items-center gap-4">
                        <p class="text-base font-semibold text-gray-1">
                          {{ $modalidade['modalidade']->nome }}
                        </p>


                        @if (Count($modalidade['modalidade']->registrations) < $modalidade['total_modalidade'])
                          <div class="bg-gray-3 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                            <p class="text-white text-[0.5rem] font-bold">
                              Incompleto
                            </p>
                          </div>
                        @else
                          <div class="bg-feedback-green-1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                            <p class="text-white text-[0.5rem] font-bold">
                              Completo
                            </p>
                          </div>
                        @endif

                      </div>
                      <p class="text-gray-1 text-xs">
                        {{ Count($modalidade['modalidade']->registrations) }} inscrições
                      </p>
                    </div>
                    <div class="w-[38px] h-[38px] rounded-full shrink-0">
                      <img src="/images/svg/modalidades/modalidade-{{ $modalidade['modalidade']->id }}.svg" class="w-full h-full object-cover" alt="">
                    </div>
                  </div>
                  <div class="flex flex-wrap gap-3">
                    <button onclick="window.open('/admin/modalidade/{{ $modalidade['modalidade']->id }}', '_self')" class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                      Ver modalidade
                    </button>
                    <button onclick="window.open('/admin/registration/create/{{ $modalidade['modalidade']->id }}', '_self')" class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                      Adicionar atleta
                    </button>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
