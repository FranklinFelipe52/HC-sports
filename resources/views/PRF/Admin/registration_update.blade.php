@extends('Admin.base')

@section('title', 'Atualizar dados da inscrição - Circuito Dunas 2026')


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
                Editar inscrição
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Editar inscrição
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
              <a href="/admin/users/{{ $atleta->id }}/update" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-gray-2 hover:ring-2 hover:ring-gray-2 hover:ring-opacity-50 bg-white transition">
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
                Dados da inscrição
              </h1>

              <form method="post" action="/admin/registrations/{{ $registration->id }}/update" class="w-full max-w-[700px]">
                @csrf
                <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
                  <div class="flex gap-4 mb-6">
                    <div class="flex-1">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="category">
                        Categoria / Distância
                      </label>
                      <div class="relative">
                        <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="category" id="category">
                          @foreach ($categorys as $category_item)
                            <option value="{{ $category_item->id }}" @if ($category_item->id == $category->id) selected @endif>{{ $category_item->nome }}</option>
                          @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                        </div>
                      </div>
                    </div>
                    <div class="flex-1">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_equipe">
                        Equipe <span class="text-sm text-gray-3">(opcional)</span>
                      </label>
                      <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="input_equipe" name="equipe" value="{{ $registration->equipe }}" placeholder="Nome da equipe" />
                      @error('equipe')
                        <p class="text-red-600">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>

                  <div class="flex gap-4 mb-6">
                    <div class="flex-1">
                      <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_size_tshirt_field">
                        Tamanho da camiseta
                      </label>
                      <div class="relative">
                        <select class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="size_tshirt" id="inscricao_size_tshirt_field">
                          <option value="">Selecione</option>
                          @foreach ($size_tshirts as $size_tshirt_item)
                            <option value="{{ $size_tshirt_item->id }}" @if ($size_tshirt && $size_tshirt->id == $size_tshirt_item->id) selected @endif>{{ $size_tshirt_item->nome }}</option>
                          @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                          <img src="/images/PRF/svg/chevron-down.svg" alt="" />
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
  </script>
@endsection
