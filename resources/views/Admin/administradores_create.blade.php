@extends('Admin.base')

@section('title', 'Cadastrar administradores')

@section('content')

  @include('components.admin.menu_mobile', ['type' => 2])


  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 2]);
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
              <a href="/inscricao/admin/administradores" class="text-xs text-gray-1 block hover:underline">
                Administradores
              </a>
            </div>
            <img src="/inscricao/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Adicionar Administrador
            </div>
          </nav>
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Cadastramento de Administrador
          </h1>
        </header>

        <form method="post" action="/admin/administradores/store" class="w-full max-w-[700px]">
          @csrf
          <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
            <div class="flex flex-wrap gap-6 mb-6">
              <div class="grow sm:grow-0">
                <div class="group @error('cpf') error @enderror">
                  <div class="relative">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cpf_adicionar_atleta_form">
                      CPF
                    </label>
                    <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="cpf_criar_administrador_form" name="cpf" value="{{ old('cpf') }}" placeholder="Ex.: 123.456.789-10" />

                    @error('cpf')
                      <div class="absolute bg-white top-[50%] right-3">
                        <img src="/inscricao/images/svg/input-error.svg" alt="">
                      </div>
                    @enderror
                  </div>
                </div>
                @error('cpf')
                  <p class="text-input-error text-sm pt-2">{{ $message }}</p>
                @enderror
              </div>

              <div class="grow group @error('email') error @enderror">
                <div class="relative">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="email_adicionar_atleta_form">
                    E-mail
                  </label>
                  <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:focus-input-error text-gray-1 placeholder:text-gray-3 transition" type="email" id="email_adicionar_atleta_form" name="email" value="{{ old('email') }}" placeholder="joao.silva@oab.org.br" />
                  @error('email')
                    <div class="absolute bg-white top-[50%] right-3">
                      <img src="/inscricao/images/svg/input-error.svg" alt="">
                    </div>
                  @enderror
                </div>
                @error('email')
                  <p class="text-input-error text-sm pt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="grow mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="nome_adicionar_atleta_form">
                Nome
              </label>
              <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="nome_adicionar_atleta_form" name="nome" value="{{ old('nome') }}" onkeyup="this.value = this.value.toUpperCase();" placeholder="Ex.: João Toledo da Silva" />
              @error('nome')
                <p class="text-input-error text-sm pt-2">{{ $message }}</p>
              @enderror
            </div>

            <div class="grow mb-6">
              <label class="text-gray-1 font-semibold text-sm inline-block mb-2" for="select_exemplo">
                Atribuição
              </label>
              <div class="relative max-w-[300px]">
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="rule" value="{{ old('rule') }}" id="select_exemplo">
                  <option value="" @if (!old('rule')) selected @endif disabled>
                    Selecione
                  </option>
                  @foreach ($rules as $rule)
                    <option value="{{ $rule->id }}" @if (old('rule') == $rule->id) selected @endif>{{ $rule->tipo }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/inscricao/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
              @error('rule')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>

            <div class="grow">
              <label class="text-gray-1 font-semibold text-sm inline-block mb-2" for="select_exemplo">
                Selecione a UF
              </label>
              <div class="relative max-w-[300px]">
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="uf" value="{{ old('uf') }}" id="select_exemplo">
                  <option value="" @if (!old('uf')) selected @endif disabled>
                    Selecione
                  </option>
                  @foreach ($federative_units as $federative_unit)
                    <option value="{{ $federative_unit->id }}" @if (old('uf') == $federative_unit->id) selected @endif>{{ $federative_unit->initials }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/inscricao/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
              @error('uf')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="flex flex-wrap justify-between gap-6">
            <button type="button" onclick="window.open('/admin/administradores', '_self')" class="order-2 sm:order-1 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit rounded bg-white transition">
              <p class="text-gray-1 underline text-sm font-normal font-poppins">
                Cancelar
              </p>
            </button>
            <button type="submit" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
              <p class="text-white text-sm font-bold font-poppins">
                Cadastrar
              </p>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/inscricao/frontend/dist/js/index.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

    new Cleave('[data-mask="cpf"]', {
      blocks: [3, 3, 3, 2],
      delimiters: ['.', '.', '-'],
      numericOnly: true,
    });
  </script>
  </body>

  </html>
