<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar administrador - Sistema de inscrição - Olimpíadas OAB</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" href="/frontend/dist/css/style.css">
</head>

<body class="h-screen">

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral');
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/src/pages/admin/dashboard.html" class="text-xs text-gray-1 block hover:underline">
                Administradores
              </a>
            </div>
            <img src="/frontend/dist/images/svg/chevron-left-breadcrumb.svg" alt="">
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
        @if (Session::has('erro'))
        <div class="alert alert-danger my-2" role="alert">
            {{Session('erro')}}
        </div>
        @endif
          <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
            <div class="flex flex-wrap gap-6 mb-6">
              <div class="grow sm:grow-0">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cpf_adicionar_atleta_form">
                  CPF
                </label>
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cpf_adicionar_atleta_form" name="cpf" value="{{ old('cpf') }}" placeholder="Ex.: 123.456.789-10" />
                @error('cpf')<p class="text-danger">{{ $message }}</p>@enderror
              </div>

              <div class="grow">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="email_adicionar_atleta_form">
                  E-mail
                </label>
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="email_adicionar_atleta_form" name="email" value="{{ old('email') }}" placeholder="jeffersonthawan@gmail.com" />
                @error('email')<p class="text-danger">{{ $message }}</p>@enderror
              </div>

              <div class="grow">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="nome_adicionar_atleta_form">
                  Nome
                </label>
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="nome_adicionar_atleta_form" name="nome" value="{{ old('nome') }}" placeholder="Ex.: jefferson thawan" />
                @error('nome')<p class="text-danger">{{ $message }}</p>@enderror
              </div>
            </div>

            <div>
              <label class="text-gray-1 font-semibold text-sm inline-block mb-2" for="select_exemplo">
                Atribuição
              </label>
              <div class="relative max-w-[300px]">
                <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="rule" id="select_exemplo">
                  <option value="" selected disabled>
                    Selecione
                  </option>
                  @foreach ($rules as $rule )
                        <option value="{{$rule->id}}">{{$rule->tipo}}</option>
                        @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/frontend/dist/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
              @error('rule')<p class="text-danger">{{ $message }}</p>@enderror
            </div>

            <div>
              <label class="text-gray-1 font-semibold text-sm inline-block mb-2" for="select_exemplo">
                Selecione a UF
              </label>
              <div class="relative max-w-[300px]">
                <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="uf" id="select_exemplo">
                  <option value="" selected disabled>
                    Selecione
                  </option>
                  @foreach ($federative_units as $federative_unit )
                        <option value="{{$federative_unit->id}}">{{$federative_unit->initials}}</option>
                        @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/frontend/dist/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
              @error('uf')<p class="text-danger">{{ $message }}</p>@enderror
            </div>
          </div>
          <div class="flex flex-wrap justify-between gap-6">
            <button class="order-2 sm:order-1 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit rounded bg-white transition">
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
  <script type="module" src="/frontend/dist/js/index.js"></script>
</body>

</html>