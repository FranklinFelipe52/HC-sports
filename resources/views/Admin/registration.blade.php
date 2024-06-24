@extends('Admin.base')

@section('title', 'Atleta - Comprovante de inscrição ')

@section('content')

{{-- modal validar inscrição --}}
    <div id="modal-validar-inscricao-{{ $registration->id }}" class="hidden">
      <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
        <div class="bg-white mx-3 p-3 md:p-6 rounded-lg w-full max-w-[500px]">
          <!-- modal header -->
          <div class="text-gray-1 text-lg md:text-xl font-semibold">
            <p>
              Confirmar validação de Inscrição
            </p>
          </div>
          <hr class="my-4">

          <!-- modal body -->
          <div class="text-gray-1 text-base">
            <p>
              Confirme se realmente deseja validar essa inscrição
            </p>
          </div>

          <!-- modal footer - actions -->
          <div class="flex justify-end gap-4 flex-wrap mt-10">
            <button data-modalId="modal-validar-inscricao-{{ $registration->id }}" data-action="close" class="bg-white border border-black text-v1 text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-gray-4 hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0">
              Cancelar
            </button>
            <a target="_self" href="/admin/pagamentos/confirm/{{ $registration->payment->id }}" class="bg-brand-a1 border border-brand-a1 text-white text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-v1 hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0">
              Validar
            </a>
          </div>
        </div>
      </div>
    </div>


 {{-- modal excluir inscrição --}}
  <div id="modal-excluir-inscricao-{{ $registration->id }}" class="hidden">
    <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
      <div class="bg-white mx-3 p-3 md:p-6 rounded-lg w-full max-w-[532px]">
        <!-- modal header -->
        <div>
          <p class="text-gray-1 text-lg md:text-xl font-semibold">
            Tem certeza de que deseja excluir esta inscição?
          </p>
        </div>

        <hr class="mt-4 mb-3.5">

        <!-- modal body -->
        <div>
          <p class="text-gray-1 text-base">
            Esta ação é destrutiva e apagará todos os dados desta inscrição.
          </p>
        </div>

        <!-- modal footer - actions -->
        <div class="flex justify-end gap-4 flex-wrap mt-10">
          <a target="_self" role="button" href="/admin/registration/delete/{{ $registration->id }}" class="flex text-brand-v1 text-sm font-bold font-poppins items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
            Excluir Inscrição
          </a>
          <button data-modalId="modal-excluir-inscricao-{{ $registration->id }}" data-action="close" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-black hover:ring-2 hover:ring-black hover:ring-opacity-50 bg-black transition">
            <p class="text-white text-sm font-bold font-poppins">
              Cancelar
            </p>
          </button>
        </div>
      </div>
    </div>
  </div>

  @include('components.admin.menu_mobile', ['type' => 4])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type'=> 0]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
    @if(Session('admin')->personification)
    @include('components.admin.personification_nav')
    @endif
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a target="_self" href="{{route('users_admin')}}" class="text-xs text-gray-1 block hover:underline">
                Atletas
              </a>
            </div>
            <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
            <div>
              <a target="_self" href="{{route('user_admin', ['id' => $registration->user->id ])}}" class="text-xs text-gray-1 block hover:underline">
                @if ($registration->user->nome_completo)
                  {{ $registration->user->nome_completo }}
                @else
                  {{ $registration->user->email }}
                @endif
              </a>
            </div>
            <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Visualização da inscrição
            </div>
          </nav>
          <div class="flex gap-4 items-center flex-wrap">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              @if ($registration->user->nome_completo)
                {{ $registration->user->nome_completo }}
              @else
                {{ $registration->user->email }}
              @endif
            </h1>
            <div class="@if ($registration->status_regitration->id == 1) bg-feedback-fill-green @elseif ($registration->status_regitration->id == 3) bg-feedback-fill-purple @endif     py-1 px-1.5 rounded-full inline-block w-fit h-fit">
              <p class="@if ($registration->status_regitration->id == 1) text-feedback-green-1 @elseif ($registration->status_regitration->id == 3) text-feedback-purple @endif text-xs">
                {{ $registration->status_regitration->status }}
              </p>
            </div>
          </div>
        </header>

        <div class="w-full max-w-[700px]">
          <div class="border border-gray-5 rounded-lg mb-6">
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  CPF
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->user->cpf); ?>
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  E-mail
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->user->email }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Modalidade de interesse
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->modalities->nome }}
                </p>
              </div>
            </div>
            @if (!($registration->modalities->mode_modalities->id == 1))
              <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-1 font-semibold">
                    Categoria
                  </p>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-2 font-normal">
                    @if($registration->modalities->mode_modalities->id == 2)
                    @foreach ($registration->modalities_categorys as $category )
                    - {{ $category->nome }} <br/>
                    @endforeach
                    @else
                    {{ $registration->modalities_category->nome }}
                    @endif
                  </p>
                </div>
              </div>
            @endif
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Pagamento via
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->type_payment->type }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Status
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->status_regitration->status }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Valor
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  @if (!is_null($registration->Payment->mount))
                    <?php echo "R$ " . number_format($registration->Payment->mount, 2, ',', ''); ?>
                  @else
                    -
                  @endif
                </p>
              </div>
            </div>
            <!--<div class="grid grid-cols-2 gap-2 sm:gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-1 font-semibold">
                    Comprovante de pagamento
                  </p>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <button class="inline-flex items-center gap-3 bg-fill-base p-2 pr-8 rounded-lg hover:bg-gray-6 transition">
                    <div class="w-[30px] h-[30px]">
                      <img src="{{asset('/images/svg/link.svg')}}" class="h-full w-full object-cover" alt="">
                    </div>
                    <p class="text-sm text-gray-1">
                      comprovante-inscrição.pdf
                    </p>
                  </button>
                </div>
              </div>-->
          </div>
          <div class="flex flex-wrap justify-between gap-6">
            <button data-modalId="modal-excluir-inscricao-{{ $registration->id }}" data-action="open" class="flex text-brand-v1 text-sm font-bold font-poppins items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
                <img src="{{asset('/images/svg/trash.svg')}}" alt="">
                <p class="text-brand-v1 text-sm font-bold font-poppins">
                    Excluir Inscrição
                </p>
            </button>
            <div></div>
            <div class="flex gap-4">
              @if (!($registration->type_payment_id == 2 && $registration->status_regitration_id == 1))
                @if ($registration->modalities_id == 9 || $registration->modalities_id == 10)
                  <a target="_self" href="/admin/registration/update/{{ $registration->id }}?gender={{ $registration->user->sexo }}" class="flex items-center justify-center w-fit text-sm font-bold text-brand-a1 p-2 px-4 rounded-md border border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    Editar
                  </a>

                @else
                  <a target="_self" href="/admin/registration/update/{{ $registration->id }}" class="flex items-center justify-center w-fit text-sm font-bold text-brand-a1 p-2 px-4 rounded-md border border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    Editar
                  </a>
                @endif
              @endif
              @if (!($registration->status_regitration->id == 1) && Session('admin')->rule->id == 1)
                <button data-modalId="modal-validar-inscricao-{{ $registration->id }}" data-action="open" class="text-center text-sm font-semibold text-white p-2 rounded bg-brand-a1 border border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 transition">
                  Validar inscrição
                </button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- js -->
<script type="module" src="{{asset('/frontend/dist/js/index.js')}}"></script>
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
