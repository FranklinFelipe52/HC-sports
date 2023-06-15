@extends('Admin.base')

@section('title', 'Dashboard')

@section('content')

  @include('components.admin.menu_mobile', ['type' => 1])

<!-- grid principal -->
<div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

  <!-- Menu lateral -->
  <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
    @include('components.admin.menu_lateral', ['type' => 1])
  </div>

  <!-- Conteúdo da página -->
  <div class="order-1 sm:order-2 overflow-hidden">
    @if(Session('admin')->personification)
    @include('components.admin.personification_nav')
    @endif
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

            <!-- atualização -->
            @foreach ($atualizacoes as $atualizacao)
            <li class="flex flex-wrap gap-4 sm:gap-2 xl:gap-4 items-start pb-6 border-b border-gray-200 hover:bg-fill-base transition w-full">
              <div class="flex-shrink-0 w-[37px] h-[37px] my-auto overflow-hidden hidden min-[360px]:block">
                <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
              </div>
              <div class="grow space-y-1">
                <a href="/admin/users/{{ $atualizacao->id }}" class="text-base text-gray-1 font-semibold">{{ $atualizacao->nome_completo }}</a>
                <p class="text-xs text-gray-1 font-normal">{{ $atualizacao->status }}</p>
              </div>
              <div class="flex gap-2.5">
                <p class="text-xs text-gray-600 font-normal"><?php echo date('d M', strtotime($atualizacao->created_at)); ?></p>
              </div>
            </li>
            @endforeach
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
                      {{ $modalidade->nome }}
                    </p>

                  </div>
                  <p class="text-gray-1 text-xs">
                    @if (Session('admin')->rule->id == 1)

                    @if(Session('admin')->personification)
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
                <div class="w-[38px] h-[38px] rounded-full shrink-0">
                  <img src="/images/svg/modalidades/modalidade-{{ $modalidade->id }}.svg" class="w-full h-full object-cover" alt="">
                </div>
              </div>
              @if ($modalidade->id == 9 || $modalidade->id == 10)
              <div class="flex flex-wrap gap-3">
                <a href="/admin/modalidade/{{ $modalidade->id }}" class="grow text-center text-xs font-semibold text-gray-1 p-2 rounded-lg border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                  Ver modalidade
                </a>

                <div class="flex flex-wrap gap-3 w-full">
                  <!--
                   <a  href="/admin/registration/create/{{ $modalidade->id }}?gender=M"  class="grow gap-4 px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                        <p class="text-white text-xs text-center font-bold font-poppins">
                            Adicionar atleta masculino
                        </p>
                    </a>
                    <a href="/admin/registration/create/{{ $modalidade->id }}?gender=F" class="grow gap-4 px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                        <p class="text-white text-xs text-center font-bold font-poppins">
                            Adicionar atleta feminina
                        </p>
                    </a>
                  -->
                  <a  class="grow gap-4 px-4 py-2.5 rounded-lg border-[1.5px]  hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 bg-opacity-60 transition">
                    <p class="text-white text-xs text-center font-bold font-poppins">
                        Adicionar atleta masculino
                    </p>
                </a>
                <a  class="grow gap-4 px-4 py-2.5 rounded-lg border-[1.5px]  hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 bg-opacity-60 transition">
                    <p class="text-white text-xs text-center font-bold font-poppins">
                        Adicionar atleta feminina
                    </p>
                </a>
                </div>

              </div>
              @else
              <div class="flex flex-wrap gap-3">
                <a href="/admin/modalidade/{{ $modalidade->id }}" class="grow text-center text-xs font-semibold text-gray-1 p-2 rounded-lg border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                  Ver modalidade
                </a>
                <!--
                <a href="/admin/registration/create/{{ $modalidade->id }}" class="grow gap-4 px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                    <p class="text-white text-xs text-center font-bold font-poppins">
                        Adicionar atleta
                    </p>
                </a>
                -->
                <a class="grow gap-4 px-4 py-2.5 rounded-lg border-[1.5px]  hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 bg-opacity-60 transition">
                  <p class="text-white text-xs text-center font-bold font-poppins">
                      Adicionar atleta
                  </p>
              </a>
                
                
              </div>
              @endif

            </div>
            @endforeach

          </div>
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
</script>
@endsection
