@extends('Admin.base')

@section('title', 'Atualizar dados do atleta - Meia Maratona PRF')


@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 4]) --}}

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
                <a target="_self" href="{{route('users_admin')}}" class="text-xs text-gray-1 block hover:underline">
                  Atletas
                </a>
              </div>
              <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
              <div>
                <a target="_self" href="{{route('user_admin', ['id' => $atleta->id ])}}" class="text-xs text-gray-1 block hover:underline">
                  @if ($atleta->nome_completo)
                    {{ $atleta->nome_completo }}
                  @else
                    {{ $atleta->email }}
                  @endif
                </a>
              </div>
              <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
              <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
                Atualização de dados
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Atualização de dados
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
          <div class="md:col-span-4 lg:col-span-3 mb-6">
            <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex gap-4 sm:gap-8 md:block">
              <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                <img src="{{asset('/images/svg/user-circle.svg')}}" class="w-full h-full object-cover" alt="">
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
              <div class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-prfA1 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#000E4B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-prfA1 text-sm font-bold font-poppins">
                  Editar perfil
                </p>
              </div>
              <a target="_self" href="{{route('register_update_admin_get', ['id' => $atleta->registrations[0]['id']])}}" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-gray-2 hover:ring-2 hover:ring-gray-2 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-2 text-sm font-bold font-poppins">
                  Editar inscrição
                </p>
              </a>
              {{-- <a target="_self" href="/admin/users/password_reset/{{ $atleta->id }}" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 15V17M6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V13C20 12.4696 19.7893 11.9609 19.4142 11.5858C19.0391 11.2107 18.5304 11 18 11H6C5.46957 11 4.96086 11.2107 4.58579 11.5858C4.21071 11.9609 4 12.4696 4 13V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21ZM16 11V7C16 5.93913 15.5786 4.92172 14.8284 4.17157C14.0783 3.42143 13.0609 3 12 3C10.9391 3 9.92172 3.42143 9.17157 4.17157C8.42143 4.92172 8 5.93913 8 7V11H16Z" stroke="#0095D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-prfA1 text-sm font-bold font-poppins">
                  Resetar senha
                </p>
              </a> --}}
              {{-- @if ($atleta->registered)
                <a target="_self" href="/admin/users/password_update/{{ $atleta->id }}" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-white transition">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15V17M6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V13C20 12.4696 19.7893 11.9609 19.4142 11.5858C19.0391 11.2107 18.5304 11 18 11H6C5.46957 11 4.96086 11.2107 4.58579 11.5858C4.21071 11.9609 4 12.4696 4 13V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21ZM16 11V7C16 5.93913 15.5786 4.92172 14.8284 4.17157C14.0783 3.42143 13.0609 3 12 3C10.9391 3 9.92172 3.42143 9.17157 4.17157C8.42143 4.92172 8 5.93913 8 7V11H16Z" stroke="#0095D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <p class="text-brand-prfA1 text-sm font-bold font-poppins">
                    Alterar senha
                  </p>
                </a>
              @endif --}}
            </div>
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Dados do atleta
              </h1>

              <form id="form_discounts" method="post" action="{{route('user_update_admin_post', ['id'=>$atleta->id])}}" class="w-full max-w-[700px]">
                @csrf
                <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
                  <div class="flex gap-4 mb-6">
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_cpf_field">
                        CPF
                      </label>
                      <input required value="{{ $atleta->cpf }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="atualizar_cpf_field" name="cpf" placeholder="Digite o seu CPF" />
                    </div>
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_email_field">
                        E-mail
                      </label>
                      <input required value="{{ $atleta->email }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="atualizar_email_field" placeholder="Digite o seu E-mail" name="email" />
                    </div>
                  </div>

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_nome_completo_field">
                      Nome completo
                    </label>
                    <input onkeyup="this.value = this.value.toUpperCase();" value="{{ $atleta->nome_completo }}" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="atualizar_nome_completo_field" name="nome" placeholder="Digite o seu nome completo" />
                  </div>

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_contato_field">
                      Contato
                    </label>
                    <input onkeyup="this.value = this.value.toUpperCase();" value="{{ $atleta->phone }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="registration_phone_field" name="phone" placeholder="Digite o número de contato" />
                  </div>

                  <div class="flex gap-4 mb-6">
                    <div class="grow">
                      <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="atualizar_data_nasc_field">
                        Nascimento
                      </label>
                      <div class="relative">
                        <input value="{{ date('d/m/Y', strtotime($atleta->data_nasc)) }}" required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="atualizar_data_nasc_field" name="data_nasc" placeholder="DD/MM/AAAA" />
                        <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                          <img src="{{asset('/images/PRF/svg/calendar.svg')}}" alt="" />
                        </div>
                      </div>
                      @error('data_nasc')
                        <p class="text-red-600">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_genero_field">
                        Gênero
                      </label>
                      <div class="relative">
                        <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="sexo" id="atualizar_genero_field">
                          <option value="M" @if ($atleta->sexo == 'M') selected @endif>Masculino</option>
                          <option value="F" @if ($atleta->sexo == 'F') selected @endif>Feminino</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="{{asset('/images/PRF/svg/chevron-down.svg')}}" alt="" />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_pcd_field">
                      Possui deficiência física comprovada? (PCD)
                    </label>

                    <div class="relative">
                      <select data-item="select" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="pcd" id="inscricao_pcd_field">
                        <option value="N" selected>Não</option>
                        @foreach ($deficiencys as $deficiency)
                          @if ($atleta->prf_deficiency)
                            <option @if ($atleta->prf_deficiency->id == $deficiency->id) @selected(true) @endif value={{ $deficiency->id }}>{{ $deficiency->nome }}</option>
                          @else
                            <option value={{ $deficiency->id }}>{{ $deficiency->nome }}</option>
                          @endif
                        @endforeach
                      </select>
                      <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <img src="{{asset('/images/PRF/svg/chevron-down.svg')}}" alt="" />
                      </div>
                    </div>
                  </div>

                  <div class="flex gap-4">
                    <div class="">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="is_servidor">
                        É servidor da PRF?
                      </label>

                      <div class="relative">
                        <select data-item="select" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="is_servidor" id="is_servidor">
                          <option value="0" @if ($atleta->is_servidor == 0) selected @endif>Não</option>
                          <option value="1" @if ($atleta->is_servidor == 1) selected @endif>Sim</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="{{asset('/images/PRF/svg/chevron-down.svg')}}" alt="" />
                        </div>
                      </div>
                    </div>

                    <div id="matricula-inputbox" class="grow hidden">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_matricula_field">
                        Matrícula
                      </label>
                      <input oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $atleta->servidor_matricula }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cadastro_matricula_field" name="servidor_matricula" value="{{ old('servidor_matricula') }}" placeholder="Digite a sua matrícula" />
                    </div>
                  </div>
                </div>
                <div class="flex gap-6">
                  <button type="submit" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
                    <p class="text-white text-sm font-bold font-poppins">
                      Salvar alterações
                    </p>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

    new Cleave('#atualizar_cpf_field', {
      blocks: [3, 3, 3, 2],
      delimiters: ['.', '.', '-'],
      numericOnly: true,
    });

    new Cleave('#registration_phone_field', {
      blocks: [2, 5, 4],
      delimiters: [' ', '-'],
      numericOnly: true,
    });

    new Cleave('#atualizar_data_nasc_field', {
      blocks: [2, 2, 4],
      delimiters: ['/', '/'],
      numericOnly: true,
    });

    const isPrfSelect = document.querySelector('#is_servidor');
    const matriculaInputBox = document.querySelector('#matricula-inputbox');
    const matriculaInput = matriculaInputBox.querySelector('input');

    isPrfSelect.addEventListener('change', handlePrfSelect);

    function handlePrfSelect(e) {
      if (e.target.value == '1') {
        matriculaInputBox.classList.remove('hidden');
        matriculaInput.setAttribute('required', 'required');
      } else {
        matriculaInputBox.classList.add('hidden');
        matriculaInput.removeAttribute('required');
      }
    }

    if (isPrfSelect.value == '1') {
      matriculaInputBox.classList.remove('hidden');
      matriculaInput.setAttribute('required', 'required');
    } else {
      matriculaInputBox.classList.add('hidden');
      matriculaInput.removeAttribute('required');
    }
  </script>
@endsection
