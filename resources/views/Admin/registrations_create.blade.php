<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar atleta - Sistema de inscrição - Olimpíadas OAB</title>

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
          <!-- <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/src/pages/admin/dashboard.html" class="text-xs text-gray-1 block hover:underline">
                Dashboard
              </a>
            </div>
            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Adicionar Atleta
            </div>
          </nav> -->
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Cadastramento de Atleta
          </h1>
          @if (Session::has('erro'))
            <div class="alert alert-danger my-2" role="alert">
              {{ Session('erro') }}
            </div>
          @endif
        </header>

        <form method="post" action="/admin/registration/create/{{ $modalidade->id }}" class="w-full max-w-[700px]">
          @csrf
          <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
            <div class="flex flex-wrap gap-6 mb-6">
              <div class="grow sm:grow-0">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cpf_adicionar_atleta_form">
                  CPF
                </label>
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cpf_adicionar_atleta_form" name="cpf" placeholder="Ex.: 123.456.789-10" />
                @error('cpf')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="grow">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="email_adicionar_atleta_form">
                  E-mail
                </label>
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="email_adicionar_atleta_form" name="email" placeholder="jeffersonthawan@gmail.com" />
                @error('email')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="mb-6">
              <p class="text-sm font-semibold text-gray-1 mb-4">
                Pagamento via
              </p>

              <div class="pl-4 space-y-2.5">
                @foreach ($type_payments as $value)
                  <div class="flex items-center gap-2">
                    <input required type="radio" id="caixa_federal" name="payment" value="{{ $value->id }}" checked>
                    <label for="caixa_federal" class="text-gray-2">{{ $value->type }}</label>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="mb-6">
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_nascimento_field">
                Nascimento
              </label>
              <div class="relative">
                <input class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="date" id="cadastro_nascimento_field" name="date_nasc" />
                <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                  <img src="/images/svg/calendar.svg" alt="" />
                </div>
              </div>
              @error('date_nasc')
                <p class="text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_genero_field">
                Gênero
              </label>
              <div class="relative">
                <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sexo" id="cadastro_genero_field">
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>

                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>

            <div class="grow">
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

            <div class="mb-6">
              <p class="text-sm font-semibold text-gray-1 mb-4">
                Modalidade de Interesse
              </p>

              <ul class="list-disc pl-10 text-gray-2 text-sm font-normal">
                <li>
                  {{ $modalidade->nome }}
                </li>
              </ul>
            </div>

            @if (!($modalidade->mode_modalities->id == 1))

              <div class="mb-6">
                <p class="text-sm font-semibold text-gray-1 mb-4">
                  Selecione a categoria
                </p>
                @foreach ($modalidade->modalities_categorys as $category)
                  <div class="pl-4 space-y-2.5">
                    <div class="flex items-center gap-2">
                      <input required type="radio" id="1" name="category" value="{{ $category->id }}" checked>
                      <label for="1" class="text-gray-2">
                        {{ $category->nome }}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            @if (Count($modalidade->ranges) != 0)

              <div class="mb-6">
                <p class="text-sm font-semibold text-gray-1 mb-4">
                  Selecione a faixa
                </p>
                @foreach ($modalidade->ranges as $value)
                  <div class="pl-4 space-y-2.5">
                    <div class="flex items-center gap-2">
                      <input required type="radio" id="range-{{ $value->id }}" name="range" value="{{ $value->id }}" checked>
                      <label for="range-{{ $value->id }}" class="text-gray-2">
                        {{ $value->range }}
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
          <div class="flex flex-wrap justify-end gap-6">

            <button type="submit" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
              <p class="text-white text-sm font-bold font-poppins">
                Confirmar
              </p>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/frontend/frontend/dist/js/index.js"></script>
</body>

</html>
