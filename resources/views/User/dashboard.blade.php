@extends('User.base')

@section('title', 'Dashboard')

@section('homeClass', 'active')

@section('content')

  @foreach ($registrations as $registration)
    {{-- modal registration --}}
    <div id="modal{{ $registration->id }}" class="hidden">
      <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
        <div class="bg-white mx-3 overflow-hidden rounded-lg w-full max-w-[500px]">
          {{-- modal registration - header --}}
          <div class="bg-gray-6 p-3 md:pr-6 md:pl-5 md:py-4 flex">
            <div class="grow">
              <p class="text-gray-1 text-lg md:text-xl font-semibold">
                Detalhes da Inscrição
              </p>
            </div>
            <button data-modalId="modal{{ $registration->id }}" data-action="close" class="w-[24px] h-[24px] shrink-0">
              <img src="/images/svg/close.svg" class="w-full h-full object-cover" alt="">
            </button>
          </div>

          {{-- modal registration - body --}}
          <div class="text-gray-1 text-base">
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  CPF
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->user->cpf }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  E-mail
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->user->email }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  Modalidade
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->modalities->nome }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  Pagamento
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->type_payment->type }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.header');
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="px-6 h-full w-full grid lg:gap-8 grid-cols-1 lg:grid-cols-6 xl:grid-cols-5 sm:grid-rows-2">
        <div class="lg:row-span-2 lg:col-span-3 xl:col-span-2 flex flex-col overflow-hidden lg:border-r border-gray-5 order-2 lg:order-1">
          <header class="pt-8 pb-6">
            <h2 class="text-gray-1 text-lg font-semibold font-poppins">
              Atualizações
            </h2>
          </header>

          <div class="pb-8">
            <p class="text-gray-1 text-sm font-normal">
              As atualizações ocorrerão durante o evento
            </p>
          </div>
        </div>
        <div class="row-span-1 lg:row-span-2 lg:col-span-3 flex flex-col overflow-hidden lg:border-r border-gray-5 order-1 lg:order-2">
          <header class="pt-8 pb-6">
            <h2 class="text-gray-1 text-lg font-semibold font-poppins">
              Suas inscrições
            </h2>
          </header>

          <div class="overflow-hidden flex flex-col relative scroll-fade">
            <!-- grid de modalidades -->
            <div class="pt-4 pb-8 pr-4 overflow-auto grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
              @if (count($registrations) !== 0)
                @foreach ($registrations as $registration)
                  <!-- inscrição -->
                  <div class="space-y-8 p-4 border border-gray-5 rounded-lg">
                    <div class="flex justify-between">
                      <div>
                        <div class="flex items-center gap-4">
                          <p class="text-base font-semibold text-gray-1">
                            {{ $registration->modalities->nome }}
                          </p>
                          <div class="@if ($registration->status_regitration->id == 1) bg-feedback-green-1 @elseif ($registration->status_regitration->id == 3) bg-feedback-fill-purple @endif  py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                            <p class="text-white text-[0.5rem] font-bold">
                              {{ $registration->status_regitration->status }}
                            </p>
                          </div>

                        </div>
                        <p class="text-gray-1 text-xs mt-[2px]">
                          Equipe {{ $registration->user->address->federativeUnit->name }}
                        </p>
                      </div>
                      <div class="w-[38px] h-[38px] rounded-full shrink-0">
                        <img src="/images/svg/modalidades/modalidade-{{ $registration->modalities->id }}.svg" class="w-full h-full object-cover" alt="">
                      </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                      <button data-modalId="modal{{ $registration->id }}" data-action="open" class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                        Detalhes
                      </button>
                      @if ($registration->status_regitration->id == 1)
                        <button onclick="window.open('/registration/proof/{{ $registration->id }}', '_self')" class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                          Ver Comprovante
                        </button>
                      @elseif ($registration->status_regitration->id == 3)
                        <button onclick="window.open('/registration/proof/{{ $registration->id }}', '_self')" class="text-xs font-semibold text-brand-a1 grow p-2 rounded border border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                          Efetuar pagamento
                        </button>
                      @endif
                    </div>
                  </div>
                @endforeach
              @else
                <div class="bg-feedback-fill-blue p-4" role="alert">
                  <p class="text-brand-a1">Nenhuma inscrição cadastrada.</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
