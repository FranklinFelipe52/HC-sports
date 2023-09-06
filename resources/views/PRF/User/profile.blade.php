@extends('PRF.base')

@section('title', 'Perfil do usuário - Meia Maratona PRF')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 5]) --}}

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral', ['menuItemActive' => 2]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Perfil
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

                  <?php echo explode(' ', $user->nome_completo)[0] . ' ' . explode(' ', $user->nome_completo)[1]; ?>
                </p>
              </div>
            </div>

            <div class="flex gap-4 flex-wrap">
              {{-- <a href="/admin/profile/update" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#0095D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-a1 text-sm font-bold font-poppins">
                  Editar perfil
                </p>
              </a> --}}
              {{-- <a href="/admin/profile/password_reset" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                <img src="/images/svg/padlock.svg" alt="">
                <p class="text-brand-a1 text-sm font-bold font-poppins">
                  Alterar senha
                </p>
              </a> --}}
            </div>

          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Nome Completo
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      {{ $user->nome_completo }}
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      CPF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $user->cpf); ?>
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
                      {{ $user->email }}
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
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($user->phone)
                        {{ $user->phone }}
                      @else
                        -
                      @endif
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Data de nascimento
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      {{ date('d/m/Y', strtotime($user->data_nasc)) }}
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
                      @if ($user->sexo == 'M')
                        Masculino
                      @elseif ($user->sexo == 'F')
                        Feminino
                      @endif
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      É servidor da PRF?
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($user->is_servidor == 0)
                        Não
                      @elseif ($user->is_servidor == 1)
                        Sim
                      @endif
                    </p>
                  </div>
                </div>
                @if ($user->is_servidor == 1)
                  <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-1 font-semibold">
                        Matrícula PRF
                      </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <p class="text-sm text-gray-2 font-normal">
                        {{ $user->servidor_matricula }}
                      </p>
                    </div>
                  </div>
                @endif
              </div>
              <div class="bg-feedback-fill-blue py-4 px-6 rounded-lg" role="alert">
                <p class="text-brand-prfA1">
                  Por enquanto a edição de dados não está disponível, entre em contato com um administrador caso alguma informação esteja errada.
                </p>
              </div>
              {{-- <div class="flex gap-4 flex-wrap">
                <a href="/profile/edit/{{ $user->id }}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
                  <img src="/images/svg/pencil.svg" alt="">
                  <p class="text-white text-sm font-bold font-poppins">
                    Editar perfil
                  </p>
                </a>
                <a href="/profile/password_reset/{{ $user->id }}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                  <img src="/images/svg/padlock.svg" alt="">
                  <p class="text-brand-a1 text-sm font-bold font-poppins">
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
    if ('{{ session('erro') }}') {
      showErrorToastfy('{{ session('erro') }}');
    }

    if ('{{ session('success') }}') {
      showSuccessToastfy('{{ session('success') }}');
    }

    if ('{{ session('edit_success') }}') {
      showSuccessToastfy('{{ session('edit_success') }}');
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
