@extends('Admin.base')

@section('title', 'Atualizar dados da inscrição - Corrida da Água')


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
                <a href="/inscricao/admin/users" class="text-xs text-gray-1 block hover:underline">
                  Atletas
                </a>
              </div>
              <img src="/inscricao/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div>
                <a href="/inscricao/admin/users/{{ $atleta->id }}" class="text-xs text-gray-1 block hover:underline">
                  @if ($atleta->nome_completo)
                    {{ $atleta->nome_completo }}
                  @else
                    {{ $atleta->email }}
                  @endif
                </a>
              </div>
              <img src="/inscricao/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
                Atualização de inscrição
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Atualização de inscrição
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
          <div class="md:col-span-4 lg:col-span-3 mb-6">
            <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex gap-4 sm:gap-8 md:block">
              <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                <img src="/inscricao/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
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
              <a href="/inscricao/admin/users/{{ $atleta->id }}/update" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-gray-2 hover:ring-2 hover:ring-gray-2 hover:ring-opacity-50 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-gray-2 text-sm font-bold font-poppins">
                  Editar perfil
                </p>
              </a>
              <div class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-prfA1 bg-white transition">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.2318 5.23229L18.7677 8.76822M16.7317 3.73232C17.2006 3.26342 17.8366 3 18.4997 3C19.1628 3 19.7988 3.26342 20.2677 3.73232C20.7366 4.20121 21 4.83717 21 5.50028C21 6.1634 20.7366 6.79936 20.2677 7.26825L6.49994 21.036H3V17.4641L16.7317 3.73232Z" stroke="#000E4B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-brand-prfA1 text-sm font-bold font-poppins">
                  Editar inscrição
                </p>
              </div>
            </div>
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Dados do atleta
              </h1>

              <form id="form_discounts" method="post" action="/admin/registrations/{{ $registration->id }}/update" class="w-full max-w-[700px]">
                @csrf
                <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
                  <div class="flex gap-4 mb-6">
                    <div class="flex-1">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="category">
                        Distância
                      </label>

                      <div class="relative">
                        <select data-item="select" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="category" id="category">
                          @foreach ($categorys as $category_item)
                            <option value="{{ $category_item->id }}" @if ($category_item->id == $category->id) selected @endif>{{ $category_item->nome }}</option>
                          @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="/inscricao/images/PRF/svg/chevron-down.svg" alt="" />
                        </div>
                      </div>
                    </div>
                    <div>
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_text_exemplo">
                        Equipe <span class="text-sm">(opcional)</span>
                      </label>
                      <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="input_text_exemplo" name="equipe" value="{{ $registration->equipe }}" placeholder="Digite o nome da equipe" />
                      @error('equipe')
                        <p class="text-red-600">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>

                  <div class="flex gap-4 mb-6">
                    <div class="flex-1">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_size_tshirt_field">
                        Camiseta
                      </label>
                      <div class="relative">
                        <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="size_tshirt" id="inscricao_size_tshirt_field">
                          <option selected value>Selecione</option>
                          @foreach ($size_tshirts as $size_tshirt_item)
                            <option @if ($size_tshirt->id == $size_tshirt_item->id) @selected(true) @endif value={{ $size_tshirt_item->id }}>{{ $size_tshirt_item->nome }}</option>
                          @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="/inscricao/images/PRF/svg/chevron-down.svg" alt="" />
                        </div>
                      </div>
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
