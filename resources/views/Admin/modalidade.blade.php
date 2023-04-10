@extends('Admin.base')

@section('title', $modalidade->nome . ' - Modalidades')
@section('modalidadesClass', 'active')

@section('content')


  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral',  ['type'=>3]);
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
                    {{ Count($users) }} atletas
                  </p>
                </div>
              </div>

            </div>
            <button onclick="window.open('/admin/registration/create/{{ $modalidade->id }}', '_self')" class="h-fit flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
              <p class="text-white text-sm font-bold font-poppins">
                Adicionar atleta
              </p>
            </button>
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
                @if (Count($users) != 0)
                  @foreach ($users as $user)
                    <div class="flex gap-2 items-start pb-6 border-b border-gray-200 w-full last:border-b-0 last:pb-0">
                      <div class="flex-shrink-0 w-[37px] h-[37px] my-auto overflow-hidden hidden min-[360px]:block">
                        <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
                      </div>
                      <div class="grow space-y-1">
                        <p class="text-base text-gray-1 font-semibold">
                          @if ($user->nome_completo)
                            {{ $user->nome_completo }}
                          @else
                            {{ $user->email }}
                          @endif
                        </p>
                        @if (!($modalidade->mode_modalities->id == 1))
                          <p class="text-xs text-gray-1 font-normal">
                            Categorias:
                            @foreach ($user->registrations()->where('modalities_id', $modalidade->id)->get() as $registration_category)
                              {{ $registration_category->modalities_category->nome }};
                            @endforeach
                          </p>
                        @endif

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
