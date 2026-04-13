@extends('Admin.base')

@section('title', 'Atualizar dados do atleta - Circuito Dunas 2026')


@section('content')

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
              <div>
                <a href="/admin/users/{{ $atleta->id }}" class="text-xs text-gray-1 block hover:underline">
                  @if ($atleta->nome_completo)
                    {{ $atleta->nome_completo }}
                  @else
                    {{ $atleta->email }}
                  @endif
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
                Editar perfil
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Editar perfil
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
                  {{ $atleta->nome_completo }}
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
              @if ($atleta->registrations->first())
              <a href="/admin/registrations/{{ $atleta->registrations->first()->id }}/update" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-gray-2 hover:ring-2 hover:ring-gray-2 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-2 text-sm font-bold font-poppins">
                  Editar inscrição
                </p>
              </a>
              @endif
            </div>
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Dados do atleta
              </h1>

              <form method="post" action="/admin/users/{{ $atleta->id }}/update" class="w-full max-w-[700px]">
                @csrf
                <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
                  <div class="flex gap-4 mb-6">
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_cpf_field">
                        CPF
                      </label>
                      <input required value="{{ $atleta->cpf }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="atualizar_cpf_field" name="cpf" placeholder="Digite o CPF" />
                    </div>
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_email_field">
                        E-mail
                      </label>
                      <input required value="{{ $atleta->email }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="atualizar_email_field" placeholder="Digite o E-mail" name="email" />
                    </div>
                  </div>

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="atualizar_nome_completo_field">
                      Nome completo
                    </label>
                    <input onkeyup="this.value = this.value.toUpperCase();" value="{{ $atleta->nome_completo }}" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="atualizar_nome_completo_field" name="nome" placeholder="Nome completo" />
                  </div>

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="registration_phone_field">
                      Telefone
                    </label>
                    <input value="{{ $atleta->phone }}" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="registration_phone_field" name="phone" placeholder="Número de telefone" />
                  </div>

                  <div class="flex gap-4">
                    <div class="grow">
                      <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="atualizar_data_nasc_field">
                        Nascimento
                      </label>
                      <div class="relative">
                        <input value="{{ $atleta->data_nasc ? date('d/m/Y', strtotime($atleta->data_nasc)) : '' }}" required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="atualizar_data_nasc_field" name="data_nasc" placeholder="DD/MM/AAAA" />
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
                          <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <h2 class="text-base text-gray-1 font-poppins font-semibold mb-3 mt-6">
                  Endereço
                </h2>
                <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
                  <div class="flex gap-4 mb-6">
                    <div class="w-40 shrink-0">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cep_field">
                        CEP
                      </label>
                      <input id="cep_field" name="cep" type="text" value="{{ $atleta->caern_address?->cep }}" placeholder="00000-000" class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" />
                    </div>
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cidade_field">
                        Cidade
                      </label>
                      <input id="cidade_field" name="cidade" type="text" value="{{ $atleta->caern_address?->cidade }}" placeholder="Cidade" class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" />
                    </div>
                    <div class="w-28 shrink-0">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="estado_field">
                        Estado
                      </label>
                      <div class="relative">
                        <select id="estado_field" name="estado" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition">
                          <option value="">UF</option>
                          @foreach ($federativeUnits as $fu)
                            <option value="{{ $fu->id }}" @if ($atleta->caern_address?->federative_unit_id == $fu->id) selected @endif>{{ $fu->initials }}</option>
                          @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="bairro_field">
                      Bairro
                    </label>
                    <input id="bairro_field" name="bairro" type="text" value="{{ $atleta->caern_address?->bairro }}" placeholder="Bairro" class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" />
                  </div>

                  <div class="flex gap-4 mb-6">
                    <div class="grow">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="rua_field">
                        Rua / Avenida
                      </label>
                      <input id="rua_field" name="rua" type="text" value="{{ $atleta->caern_address?->rua }}" placeholder="Nome da rua" class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" />
                    </div>
                    <div class="w-28 shrink-0">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="number_field">
                        Número
                      </label>
                      <input id="number_field" name="number" type="text" value="{{ $atleta->caern_address?->number }}" placeholder="Nº" class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" />
                    </div>
                  </div>

                  <div>
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="complemento_field">
                      Complemento <span class="text-sm text-gray-3">(opcional)</span>
                    </label>
                    <input id="complemento_field" name="complemento" type="text" value="{{ $atleta->caern_address?->complemento }}" placeholder="Apto, bloco, referência..." class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" />
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

    new Cleave('#cep_field', {
      blocks: [5, 3],
      delimiters: ['-'],
      numericOnly: true,
    });

    document.getElementById('cep_field').addEventListener('blur', function () {
      const cep = this.value.replace(/\D/g, '');
      if (cep.length !== 8) return;

      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(r => r.json())
        .then(data => {
          if (data.erro) return;
          document.getElementById('cidade_field').value   = data.localidade ?? '';
          document.getElementById('bairro_field').value   = data.bairro ?? '';
          document.getElementById('rua_field').value      = data.logradouro ?? '';
        })
        .catch(() => {});
    });
  </script>
@endsection
