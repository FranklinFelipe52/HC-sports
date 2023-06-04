@extends('Admin.base')

@section('title', $modalidade->nome . ' - Modalidades')

@section('content')

  @foreach ($registrations as $registration)
    {{-- modal registration --}}
    <div id="modal{{ $registration->id }}" class="hidden">
      <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
        <div class="bg-white mx-3 overflow-hidden rounded-lg w-full max-w-[550px]">
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
                  <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->user->cpf); ?>
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
                <p class="text-gray-2 text-sm font-normal break-all">
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
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  Status
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->status_regitration->status }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  Valor
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  @if ($registration->Payment->mount)
                    <?php echo "R$ " . number_format($registration->Payment->mount, 2, ',', ''); ?>
                  @else
                    -
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- confirmação de exclusão --}}
    <div id="modal-excluir-inscricao-{{ $registration->id }}" class="hidden">
      <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
        <div class="bg-white mx-3 p-3 md:p-6 rounded-lg w-full max-w-[500px]">
          <!-- modal header -->
          <div class="text-gray-1 text-lg md:text-xl font-semibold">
            <p>
              Tem certeza de que deseja excluir esta inscição?
            </p>
          </div>
          <hr class="my-4">

          <!-- modal body -->
          <div class="text-gray-1 text-base">
            <p>
              Esta ação é destrutiva e apagará todos os dados desta inscrição.
            </p>
          </div>

          <!-- modal footer - actions -->
          <div class="flex justify-end gap-4 flex-wrap mt-10">
            <a href="/admin/registration/delete/{{ $registration->id }}" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
              <img src="/images/svg/trash.svg" alt="">
              <p class="text-brand-v1 text-sm font-bold font-poppins">
                Excluir inscrição
              </p>
            </a>
            <button data-modalId="modal-excluir-inscricao-{{ $registration->id }}" data-action="close" class="bg-black border border-black text-white text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-black hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0">
              Cancelar
            </button>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @include('components.admin.menu_mobile', ['type' => 3])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 3]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden flex flex-col">
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

      <div class="h-full w-full overflow-hidden flex flex-col">

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
                {{ $modalidade->nome }}
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              {{ $modalidade->nome }}
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 gap-8 w-full overflow-y-auto pb-1">
          <div class="md:col-span-4 lg:col-span-3">
            <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex flex-wrap gap-4 sm:gap-8 md:block">
              <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                <img src="/images/svg/modalidades/modalidade-{{ $modalidade->id }}.svg" class="w-full h-full object-cover" alt="">
              </div>

              <hr class="hidden md:block border-gray-5">

              <div class="flex gap-2 sm:gap-8 flex-wrap md:block md:space-y-6">
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
                    @if (Session('admin')->rule->id == 1)

                      @if (Session('admin')->personification)
                        <?php
                        $users_registrations = 0;
                        
                        foreach ($modalidade->registrations as $registration) {
                            if ($registration->user->address->federative_unit_id == Session('admin')->personification) {
                                $users_registrations++;
                            }
                        }
                        ?>
                        {{ $users_registrations }} inscrições
                      @else
                        {{ Count($modalidade->registrations) }} inscrições
                      @endif
                    @else
                      <?php
                      $users_registrations = 0;
                      
                      foreach ($modalidade->registrations as $registration) {
                          if ($registration->user->address->federative_unit_id == Session('admin')->federative_unit_id) {
                              $users_registrations++;
                          }
                      }
                      
                      ?>
                      {{ $users_registrations }} inscrições
                    @endif
                  </p>
                </div>
              </div>

              {{-- <hr class="hidden md:block border-gray-5 mb-5">

              <div class="flex md:flex-col gap-4 md:gap-0">
                <a href="/src/pages/admin/modalidade-categorias.html" class="text-brand-a1 underline text-sm block">
                  Exibir categorias
                </a>

                <hr class="hidden md:block border-gray-5 my-5">

                <a href="/src/pages/admin/modalidade-relatorio.html" class="text-brand-a1 underline text-sm block">
                  Ver relatório
                </a>
              </div> --}}
            </div>
            @if ($modalidade->id == 9 || $modalidade->id == 10)
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
            {{-- <a href="/src/pages/admin/modalidade-cadastrar-categoria.html" class="h-fit flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 transition">
              <p class="text-brand-a1 text-sm font-bold font-poppins">
                Incluir categoria
              </p>
            </a> --}}
          </div>
          <div class="md:col-span-8 overflow-hidden flex flex-col min-h-[300px]">
            <div class="border border-b-0 border-gray-5 p-4 rounded-t-lg flex bg-fill-base">
              <div class="grow">
                <p class="text-base text-gray-1 font-semibold">
                  Inscrições
                </p>
              </div>
            </div>

            <!-- lista de inscrições -->
            <div class="overflow-auto pb-8">
              @if (Session('admin')->rule->id == 1 && !Session('admin')->personification)
                <div class="border border-t-0 rounded-b-lg space-y-3 pt-3">

                  @if (Count($registrations) != 0)
                    @foreach ($federative_units as $federative_unit)
                      {{-- Accordion --}}
                      <div class="group border-b last:border-0 border-gray-200" id="uf-{{ $federative_unit->code }}-registrations-accordion" data-accordion="accordion">
                        <button data-accordion="button" class="group-[.active]:bg-fill-base py-2 w-full hover:bg-fill-base transition-all flex justify-between items-center px-2" data-accordion="header" data-accordion-id="uf-{{ $federative_unit->code }}-registrations-accordion">
                          <p class="text-gray-1 font-semibold text-start">
                            Atletas {{ $federative_unit->name }} - {{ $federative_unit->initials }}
                          </p>
                          <div class="group-[.active]:hidden">
                            <img src="/images/svg/accordion-arrow.svg" class="group-hover:hidden" alt="">
                            <img src="/images/svg/accordion-arrow-active.svg" class="hidden group-hover:block" alt="">
                          </div>
                        </button>
                        <div class="px-2 transition-all" data-accordion="body">
                          @foreach ($registrations as $registration)
                            @if ($registration->user->address->federative_unit_id == $federative_unit->id)
                              <div class="flex items-end flex-wrap md:flex-nowrap justify-end gap-2 border-b border-gray-200 w-full px-4 py-3 bg-white hover:bg-fill-base transition cursor-default">
                                <div class="flex gap-2 grow">
                                  <div class="grow space-y-1">
                                    <a href="/admin/users/{{ $registration->user->id }}" class="text-sm sm:text-base text-gray-1 font-semibold break-all">
                                      @if ($registration->user->nome_completo)
                                        {{ $registration->user->nome_completo }}
                                      @else
                                        {{ $registration->user->email }}
                                      @endif
                                    </a>
                                  </div>
                                </div>
                                <div class="flex sm:items-end justify-between gap-1.5 grow sm:grow-0 mt-1 sm:mt-0">
                                  @if ($registration->status_regitration->id == 1)
                                    <div class=" bg-feedback-fill-green py-1 px-1.5 rounded-full inline-block w-fit h-fit">
                                      <p class="text-feedback-green-1 text-xs">
                                        {{ $registration->status_regitration->status }}
                                      </p>
                                    </div>
                                  @elseif ($registration->status_regitration->id == 3)
                                    <div class="bg-feedback-fill-purple py-1 px-1.5 rounded-full inline-block min-w-[148px] w-fit h-fit">
                                      <p class="text-feedback-purple text-xs">
                                        {{ $registration->status_regitration->status }}
                                      </p>
                                    </div>
                                  @endif
                                  <div class="flex flex-nowrap gap-2">
                                    <button data-modalId="modal{{ $registration->id }}" data-action="open" class="h-fit text-[10px] font-poppins font-normal text-gray-1 grow px-[8px] py-[2px] rounded-md border border-gray-2 hover:ring-1 hover:ring-gray-2 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                      Detalhes
                                    </button>
                                    @if (!($registration->type_payment_id == 2 && $registration->status_regitration_id == 1))
                                      @if ($modalidade->id == 9 || $modalidade->id == 10)
                                        <a href="/admin/registration/update/{{ $registration->id }}?gender={{ $registration->user->sexo }}" class="h-fit text-[10px] font-poppins font-normal text-gray-1 grow px-[8px] py-[2px] rounded-md border border-gray-2 hover:ring-1 hover:ring-gray-2 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                          Editar
                                        </a>
                                      @else
                                        <a href="/admin/registration/update/{{ $registration->id }}" class="h-fit text-[10px] font-poppins font-normal text-gray-1 grow px-[8px] py-[2px] rounded-md border border-gray-2 hover:ring-1 hover:ring-gray-2 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                          Editar
                                        </a>
                                      @endif
                                    @endif
                                  </div>
                                </div>
                              </div>
                            @endif
                          @endforeach
                        </div>
                        <div class="px-2 flex justify-end w-full hidden" data-accordion="footer">
                          <button class="py-2 rotate-180 transition-all" data-accordion="button" data-accordion-id="uf-{{ $federative_unit->code }}-registrations-accordion">
                            <img src="/images/svg/accordion-arrow-active.svg" class="" alt="">
                          </button>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="p-4" role="alert">
                      <p class="text-gray-3 text-sm text-center py-10">
                        Ainda não há inscrições.
                      </p>
                    </div>
                  @endif
                </div>
              @else
                <div class="border border-t-0 rounded-b-lg space-y-6">

                  @if (Count($registrations) != 0)
                    @foreach ($registrations as $registration)
                      <!-- inscrição -->
                      <div class="flex items-end flex-wrap md:flex-nowrap justify-end gap-2 border-b border-gray-200 w-full last:border-b-0 px-4 py-3 bg-white hover:bg-fill-base transition cursor-default last:rounded-b-md">
                        <div class="flex gap-2 grow">
                          <div class="flex-shrink-0 w-[37px] h-[37px] overflow-hidden min-[360px]:block">
                            <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
                          </div>
                          <div class="grow space-y-1">
                            <a href="/admin/users/{{ $registration->user->id }}" class="text-base text-gray-1 font-semibold">
                              @if ($registration->user->nome_completo)
                                {{ $registration->user->nome_completo }}
                              @else
                                {{ $registration->user->email }}
                              @endif
                            </a>
                            <p class="text-xs text-gray-1 font-normal">
                              @if (Session('admin')->rule->id == 1)
                                <strong>
                                  {{ $registration->user->address->federativeUnit->initials }}
                                </strong>
                              @endif

                            </p>
                          </div>
                        </div>
                        <div class="flex sm:flex-col sm:items-end justify-between gap-1.5 grow sm:grow-0 mt-1 sm:mt-0">
                          @if ($registration->status_regitration->id == 1)
                            <div class=" bg-feedback-fill-green py-1 px-1.5 rounded-full inline-block w-fit h-fit">
                              <p class="text-feedback-green-1 text-xs">
                                {{ $registration->status_regitration->status }}
                              </p>
                            </div>
                          @elseif ($registration->status_regitration->id == 3)
                            <div class="bg-feedback-fill-purple py-1 px-1.5 rounded-full inline-block min-w-[148px] w-fit h-fit">
                              <p class="text-feedback-purple text-xs">
                                {{ $registration->status_regitration->status }}
                              </p>
                            </div>
                          @endif
                          <div class="flex flex-nowrap gap-2">
                            <button data-modalId="modal{{ $registration->id }}" data-action="open" class="h-fit text-[10px] font-poppins font-normal text-gray-1 grow px-[8px] py-[2px] rounded-md border border-gray-2 hover:ring-1 hover:ring-gray-2 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                              Detalhes
                            </button>
                            {{-- <button data-modalId="modal-excluir-inscricao-{{ $registration->id }}" data-action="open" class="h-fit text-[10px] font-poppins font-normal text-gray-1 grow px-[8px] py-[2px] rounded-md border border-gray-2 hover:ring-1 hover:ring-gray-2 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                              Excluir
                            </button> --}}
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="p-4" role="alert">
                      <p class="text-gray-3 text-sm text-center py-10">
                        Ainda não há inscrições.
                      </p>
                    </div>
                  @endif
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script type="module" src="/js/app.js"></script>
  <script type="module">

    if('{{ session('erro') }}') {
        showErrorToastfy('{{ session('erro') }}');
    }
    if('{{ session('success') }}') {
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
        onClick: function() {}
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
        onClick: function() {}
      }).showToast();
    }
  </script>

@endsection
