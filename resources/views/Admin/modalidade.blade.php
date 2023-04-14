@extends('Admin.base')

@section('title', $modalidade->nome . ' - Modalidades')

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
      @include('components.admin.menu_lateral',  ['type'=> 3]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
              <div>
                <a href="/admin/modalidades" class="text-xs text-gray-1 block hover:underline">
                  Modalidades
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                Detalhamento da modalidade
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              {{ $modalidade->nome }}
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 gap-8 w-full overflow-hidden">
          <div class="md:col-span-4 lg:col-span-3">
            <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex gap-4 sm:gap-8 md:block">
              <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                <img src="/images/svg/modalidades/modalidade-{{ $modalidade->id }}.svg" class="w-full h-full object-cover" alt="">
              </div>

              <hr class="hidden md:block border-gray-5">

              <div class="flex flex-col sm:flex-row gap-2 sm:gap-8 flex-wrap md:block md:space-y-6">
                <div>
                  <p class="text-sm text-gray-1 font-semibold mb-1">
                    Tipo
                  </p>

                  <div class="@if ($modalidade->modalities_type->id == 1) bg-feedback-fill-blue  @else bg-feedback-fill-purple @endif py-1 px-1.5 rounded-full inline-block w-fit h-fit">

                    <p class=" @if ($modalidade->modalities_type->id == 1) text-brand-a1  @else text-feedback-purple @endif     text-sm">
                      {{ $modalidade->modalities_type->type }}
                    </p>
                  </div>
                </div>

                <div>
                  <p class="text-sm text-gray-1 font-semibold mb-1">
                    Ocupação
                  </p>

                  <p class="text-sm text-gray-2 font-normal mb-1">
                    @if(Count($registrations) > 1)
                    {{ Count($registrations) }} inscrições

                    @else
                    {{ Count($registrations) }} inscrição
                    @enderror
                    
                  </p>
                </div>
              </div>

            </div>
            
            @if ($modalidade->id == 9 || $modalidade->id == 10 )
            <div class="flex flex-col gap-3">
              <button onclick="window.open('/admin/registration/create/{{ $modalidade->id }}?gender=M', '_self')" class="h-fit flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                <p class="text-white text-sm font-bold font-poppins">
                  Adicionar atleta masculino
                </p>
              </button>
              <button onclick="window.open('/admin/registration/create/{{ $modalidade->id }}?gender=F', '_self')" class="h-fit flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                <p class="text-white text-sm font-bold font-poppins">
                  Adicionar atleta Feminino
                </p>
              </button>
            </div>
            @else
            <button onclick="window.open('/admin/registration/create/{{ $modalidade->id }}', '_self')" class="h-fit flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
              <p class="text-white text-sm font-bold font-poppins">
                Adicionar atleta
              </p>
            </button>


            @endif

            
            
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden">
            <div class="border border-b-0 border-gray-5 p-4 pb-6 rounded-t-lg flex">
              <div class="grow">
                <p class="text-base text-gray-1 font-semibold">
                  Inscrições
                </p>
              </div>
              <!-- <form action="" class="">
                                        <div class="relative">
                                          <select class="w-full min-w-[195px] px-4 py-2 rounded-lg bg-white border border-gray-5 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 text-sm placeholder:text-gray-3 appearance-none" name="filtro_modalidades_page" id="filtro_modalidades_page">
                                            <option value="" selected disabled>
                                              Filtrar por status
                                            </option>
                                            <option value="">Parcialmente confirmado</option>
                                            <option value="">Confirmado</option>
                                          </select>
                                          <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <img src="/images/svg/chevron-down.svg" alt="" />
                                          </div>
                                        </div>
                                      </form> -->
            </div>

            <!-- lista de inscrições -->
            <div class="overflow-auto pb-8">
              <div class="border border-t-0 border-gray-5 rounded-b-lg px-4 pb-6 space-y-6">
                <!-- inscrição -->
                @if (Count($registrations) != 0)
                  @foreach ($registrations as $registration)
                    <div class="flex gap-2 items-start pb-6 border-b border-gray-200 w-full last:border-b-0 last:pb-0">
                      <div class=" w-[37px] h-[37px]  min-[360px]:block">
                        <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
                      </div>
                      <div class="grow space-y-1">
                        <p class="text-base text-gray-1 font-semibold">
                          @if ($registration->user->nome_completo)
                            {{ $registration->user->nome_completo }}
                          @else
                            {{ $registration->user->email }}
                          @endif
                        </p>
                        @if (!($modalidade->mode_modalities->id == 1))
                          <p class="text-xs text-gray-1 font-normal">
                            Categorias:
                            @foreach ($registrations as $registration)
                              @if ($modalidade->mode_modalities->id == 2)

                              @foreach ($registration->modalities_categorys as $category)
                              {{ $category->nome }};
                              @endforeach

                              @else
                              {{ $registration->modalities_category->nome }};
                              @endif
                              
                            @endforeach
                          </p>
                        @endif

                      </div>
                      <div class="flex flex-col gap-2">
                        <div class="@if ($registration->status_regitration->id == 1) bg-feedback-green-1 @elseif ($registration->status_regitration->id == 3) bg-feedback-purple @endif  py-0.5 px-2 rounded-full inline-block w-full h-fit">
                          <p class="text-white  font-bold text-center">
                            {{ $registration->status_regitration->status }}
                          </p>
                        </div>
                        <div>
                          <button data-modalId="modal{{ $registration->id }}" data-action="open" class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            Detalhes
                          </button>
                          <button onclick="window.open('/admin/registration/delete/{{ $registration->id }}', '_self')"   class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            excluir
                          </button>
                        </div>
                        
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="bg-feedback-fill-blue p-4" role="alert">
                    <p class="text-brand-a1">Nenhum usuario inscrito.</p>
                  </div>

                @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
