@extends('Admin.base')

@section('title', 'Atletas - ' . $atleta->nome_completo . ' - Meia Maratona PRF')


@section('content')

  {{-- modal validar inscrição --}}
  <div id="modal-validar-inscricao-{{ $registration->id }}" class="hidden">
    <form action="/admin/registrations/{{ $registration->id }}/confirm" method="post">
      @csrf
      <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
        <div class="bg-white mx-3 p-3 md:p-6 rounded-lg w-full max-w-[500px]">
          <!-- modal header -->
          <div class="text-gray-1 text-lg md:text-xl font-semibold">
            <p>
              Confirmação de Inscrição
            </p>
          </div>
          <hr class="my-4">

          <!-- modal body -->
          <div class="">
            <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="observacao_field">
              Observação
            </label>
            <textarea id="observacao_field" name="observacao" placeholder="Adicione alguma observação (ex: motivo da liberação de inscrição)" rows="2" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition"></textarea>
          </div>

          <!-- modal footer - actions -->
          <div class="flex justify-end gap-4 flex-wrap mt-10">
            <button type="button" data-modalId="modal-validar-inscricao-{{ $registration->id }}" data-action="close" class="bg-white border border-black text-v1 text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-gray-4 hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0">
              Cancelar
            </button>
            <input type="submit" value="Confirmar" class="bg-brand-prfA1 border border-brand-prfA1 text-white text-sm font-poppins font-bold w-full sm:w-fit py-2.5 px-4 rounded flex justify-center items-center gap-2.5 hover:ring-2 hover:ring-prfA1 hover:ring-opacity-50 transition disabled:opacity-50 disabled:hover:ring-0" />
          </div>
        </div>
      </div>
    </form>
  </div>

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 2])
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
              <div>
                <a href="/admin/users" class="text-xs text-gray-1 block hover:underline">
                  Atletas
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
                @if ($atleta->nome_completo)
                  {{ $atleta->nome_completo }}
                @else
                  {{ $atleta->email }}
                @endif
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Visualização de atleta
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
          <div class="md:col-span-4 lg:col-span-3 mb-6">
            <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex gap-4 sm:gap-8 md:block">
              <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
              </div>
              <div class="flex flex-col sm:flex-row gap-2 sm:gap-8 flex-wrap md:block md:space-y-6">
                <p class="text-sm text-center text-gray-1 font-semibold mb-1">
                  {{ $atleta->nome_completo }} <br>
                  @if ($atleta->is_servidor)
                    <span class="font-bold">(Servidor)</span>
                  @endif
                </p>
              </div>
            </div>
            <div class="flex flex-col gap-4">
              <a href="/admin/users/{{ $atleta->id }}/update" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-gray-2 hover:ring-2 hover:ring-gray-2 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-2 text-sm font-bold font-poppins">
                  Editar perfil
                </p>
              </a>
            </div>
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Dados do atleta
              </h1>
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      CPF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $atleta->cpf); ?>
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
                    <p class="text-sm text-gray-2 font-normal break-all">
                      {{ $atleta->email }}
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Contato
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal break-all">
                      @if ($atleta->phone)
                        {{ $atleta->phone }}
                      @else
                        -
                      @endif
                    </p>
                  </div>
                </div>
                @if ($atleta->is_servidor)
                  <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-1 font-semibold">
                        Matrícula
                      </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-2 font-normal break-all">
                        {{ $atleta->servidor_matricula }}
                      </p>
                    </div>
                  </div>
                @endif
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Nascimento
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">

                      <?php echo date('d/m/Y', strtotime($atleta->data_nasc)); ?>
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Gênero
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($atleta->sexo == 'M')
                        Masculino
                      @else
                        Feminino
                      @endif
                    </p>
                  </div>
                </div>
                {{-- <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Celular
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($atleta->phone_number)
                        {{ $atleta->phone_number }}
                      @else
                        -
                      @endif

                    </p>
                  </div>
                </div> --}}

                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Dados de criação
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">

                      Criado em: <strong><?php echo date('d/m/Y h:i:s', strtotime($atleta->created_at)); ?></strong>

                    </p>

                  </div>
                </div>
              </div>

              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Inscrição realizada
              </h1>
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Pacote
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      {{ $registration->prf_package->nome }}
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Categoria
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal break-all">
                      {{ App\Models\PrfCategorys::find($registration->prf_categorys_id)->nome }}
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
                    <p class="font-normal break-all">
                      @if ($registration->status_regitration->id == 1)
                        <div class="bg-feedback-green-1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                          <p class="text-white text-xs font-bold text-center">
                            {{ $registration->status_regitration->status }}
                          </p>
                        </div>
                      @elseif ($registration->status_regitration->id == 3)
                        <div class="bg-feedback-purple py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                          <p class="text-white text-xs font-bold text-center">
                            {{ $registration->status_regitration->status }}
                          </p>
                        </div>
                      @endif
                    </p>
                  </div>
                </div>
                @if ($registration->status_regitration_id == 1)
                  <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-1 font-semibold">
                        Confirmação da inscrição
                      </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-2 font-normal">
                        @if (!isset($registration->prf_vauchers) && !$registration->validated_by_admin)
                          Paga com mercado pago
                        @elseif (isset($registration->prf_vauchers) && $registration->prf_vauchers->desconto < 1 && !$registration->validated_by_admin)
                          Paga com mercado pago
                        @elseif($registration->validated_by_admin)
                          Inscrição liberada pelo administrador
                        @elseif(isset($registration->prf_vauchers) && $registration->prf_vauchers->desconto == 1 && count($registration->tshirts) == 0)
                          Desconto de 100% aplicado
                        @endif
                      </p>
                    </div>
                  </div>
                @endif
                @if ($registration->validated_by_admin && $registration->observacao)
                  <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-1 font-semibold">
                        Observação
                      </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-2 font-normal">
                        {{ $registration->observacao }}
                      </p>
                    </div>
                  </div>
                @endif
              </div>
              @if ($registration->status_regitration_id != 1)
                <button data-modalId="modal-validar-inscricao-{{ $registration->id }}" data-action="open" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0">
                  <p class="text-white text-sm font-bold font-poppins">
                    Confirmar inscrição
                  </p>
                </button>
              @endif

              {{-- <div class="flex gap-4 flex-wrap">

                <a href="/profile/edit/{{ $atleta->id }}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-prfA1 hover:ring-2 bg-brand-prfA1 hover:ring-brand-prfA1 hover:ring-opacity-50 transition">
                  <img src="/images/svg/pencil.svg" alt="">
                  <p class="text-white text-sm font-bold font-poppins">
                    Editar perfil
                  </p>
                </a>
                <a href="/profile/password_reset/{{ $atleta->id }}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-white transition">
                  <img src="/images/svg/padlock.svg" alt="">
                  <p class="text-brand-prfA1 text-sm font-bold font-poppins">
                    Alterar senha
                  </p>
                </a>
                <button data-modalId="modal" data-action="open" class="lg:ml-auto flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
                  <img src="/images/svg/trash.svg" alt="">
                  <p class="text-brand-v1 text-sm font-bold font-poppins">
                    Excluir Conta
                  </p>
                </button>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('success') }}') {
      showSuccessToastfy('{{ session('success') }}');
    }

    if ('{{ session('edit_success') }}') {
      showSuccessToastfy('{{ session('edit_success') }}');
    }

    if ('{{ session('edit_error') }}') {
      showErrorToastfy('{{ session('edit_error') }}');
    }

    if ('{{ session('erro') }}') {
      showErrorToastfy('{{ session('erro') }}');
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
