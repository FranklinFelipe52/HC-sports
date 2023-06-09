@extends('Admin.base')

@section('title', 'Administrador - ' . $administrador->nome_completo)


@section('content')

  @include('components.admin.menu_mobile', ['type' => 2])
  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 2]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('admin')->personification)
        @include('components.admin.personification_nav')
      @endif
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
              <div>
                <a href="/admin/administradores" class="text-xs text-gray-1 block hover:underline">
                  Administradores
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                @if ($administrador->nome_completo)
                  {{ $administrador->nome_completo }}
                @else
                  {{ $administrador->email }}
                @endif
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Visualização de administrador
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
                  <?php echo $administrador->nome_completo ? explode(' ', $administrador->nome_completo)[0] . ' ' . explode(' ', $administrador->nome_completo)[1] : '-'; ?>
                </p>
              </div>
            </div>
            <div class="flex flex-col gap-4">
              <a href="/admin/administradores/update/{{$administrador->id}}" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#0095D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-a1 text-sm font-bold font-poppins">
                  Editar perfil
                </p>
              </a>
              {{-- <a href="/admin/administradores/password_reset/{{$administrador->id}}" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 15V17M6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V13C20 12.4696 19.7893 11.9609 19.4142 11.5858C19.0391 11.2107 18.5304 11 18 11H6C5.46957 11 4.96086 11.2107 4.58579 11.5858C4.21071 11.9609 4 12.4696 4 13V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21ZM16 11V7C16 5.93913 15.5786 4.92172 14.8284 4.17157C14.0783 3.42143 13.0609 3 12 3C10.9391 3 9.92172 3.42143 9.17157 4.17157C8.42143 4.92172 8 5.93913 8 7V11H16Z" stroke="#0095D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-a1 text-sm font-bold font-poppins">
                  Resetar senha
                </p>
              </a> --}}
              <a href="/admin/administradores/password_update/{{$administrador->id}}" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 15V17M6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V13C20 12.4696 19.7893 11.9609 19.4142 11.5858C19.0391 11.2107 18.5304 11 18 11H6C5.46957 11 4.96086 11.2107 4.58579 11.5858C4.21071 11.9609 4 12.4696 4 13V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21ZM16 11V7C16 5.93913 15.5786 4.92172 14.8284 4.17157C14.0783 3.42143 13.0609 3 12 3C10.9391 3 9.92172 3.42143 9.17157 4.17157C8.42143 4.92172 8 5.93913 8 7V11H16Z" stroke="#0095D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-a1 text-sm font-bold font-poppins">
                  Editar senha
                </p>
              </a>
            </div>
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <h2 class="text-base font-semibold text-gray-1 mb-4">
              Dados pessoais
            </h2>
            <div class="w-full">
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      CPF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $administrador->cpf); ?>
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
                      {{ $administrador->email }}
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Atribuição
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($administrador->rule_id == 1)
                        Administrador geral
                      @elseif($administrador->rule_id == 2)
                        Administrador Regional
                      @elseif($administrador->rule_id == 3)
                        Caixa de assistência
                      @endif
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      UF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($administrador->rule_id == 1)
                        -
                      @else
                        {{ $administrador->federativeUnit->name }}
                      @endif
                    </p>
                  </div>
                </div>
              </div>
            </div>
            @if (Session('admin')->rule->id == 1)
              <h2 class="text-base font-semibold text-gray-1 mb-4">
                Logs de ações
              </h2>
              <!-- Table container -->
              <div class="h-fit flex flex-col overflow-hidden">
                <!-- Table -->
                <div class="h-fit flex flex-col overflow-y-hidden overflow-x-auto" role="table">
                  <!-- Table header -->
                  <div class="border border-gray-5 min-w-[600px] rounded-t-lg" role="heading">
                    <div role="row" class="grid grid-cols-12 px-4 py-3">
                      <div role="columnheader" class="text-start col-span-4">
                        <p class="text-sm font-semibold text-gray-1">
                          Data e horário
                        </p>
                      </div>
                      <div role="columnheader" class="text-start col-span-4">
                        <p class="text-sm font-semibold text-gray-1">
                          Tipo de ação
                        </p>
                      </div>
                      <div role="columnheader" class="text-start col-span-4">
                        <p class="text-sm font-semibold text-gray-1 ">
                          Descrição
                        </p>
                      </div>
                    </div>
                  </div>

                  <!-- Table body -->
                  <div class="min-w-[600px] h-fit overflow-auto border border-t-0 border-gray-5 rounded-b-lg" data-pagination>
                    @if (Count($admin_logs) > 0)
                      @foreach ($admin_logs as $admin_log)
                        <!-- Table row -->
                        <div role="row" class="px-4 grid grid-cols-12 border-b border-b-gray-5 last:border-b-0" data-pagination-item>
                          <div role="cell" class="py-2.5 flex items-center col-span-4">
                            <p class="text-xs font-normal text-gray-2">
                              {{ $admin_log->created_at }}
                            </p>
                          </div>
                          <div role="cell" class="py-2.5 flex items-center col-span-4">
                            <p class="text-xs font-semibold text-gray-2">
                              @if ($admin_log->type_actions_admin_id == 1)
                                Confirmação de pagamento
                              @elseif ($admin_log->type_actions_admin_id == 2)
                                Exclusão de usuário
                              @elseif ($admin_log->type_actions_admin_id == 3)
                                Edição de usuário
                              @elseif ($admin_log->type_actions_admin_id == 4)
                                Resetar senha de usuários
                              @elseif ($admin_log->type_actions_admin_id == 5)
                                Excluir inscrição
                              @elseif ($admin_log->type_actions_admin_id == 6)
                                Cadastrar atleta
                              @endif
                            </p>
                          </div>
                          <div role="cell" class="py-2.5 flex items-center col-span-4">
                            <p class="text-xs font-normal text-gray-2">
                              {{ $admin_log->description }}
                            </p>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <div class="p-6">
                        <p class="text-gray-1 text-xs text-center">
                          Ainda não há logs para este administrador
                        </p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <!-- dados da tabela -->
              <div class="flex justify-end items-center pt-6 pb-4 sm:pb-16 gap-1">
                <div>
                  <p class="text-gray-3 text-sm font-normal">
                    @if (Count($admin_logs) > 1 || Count($admin_logs) == 0)
                      {{ Count($admin_logs) }} logs exibidos
                    @else
                      {{ Count($admin_logs) }} logs exibidos
                    @endif
                  </p>
                </div>
                <div class="text-[#E0E0E0]">
                  &#8226;
                </div>
                <div>
                  <a href="/admin/administradores/logs/{{ $administrador->id }}" class="font-bold font-poppins text-sm text-brand-a1">
                    Visualizar tudo
                  </a>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('edit_password_success') }}') {
      showSuccessToastfy('{{ session('edit_password_success') }}');
    }

    if ('{{ session('edit_success') }}') {
      showSuccessToastfy('{{ session('edit_success') }}');
    }

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
