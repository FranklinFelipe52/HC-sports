@extends('Admin.base')

@section('title', $modalidade->nome . ' - Adicionar atleta na modalidade ')

@section('content')
  <style>

  </style>

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 1]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/admin/dashboard" class="text-xs text-gray-1 block hover:underline">
                Dashboard
              </a>
            </div>
            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Adicionar Atleta
            </div>
          </nav>
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Cadastramento de Atleta
          </h1>
        </header>

        @if (Session::has('erro'))
          <div class="bg-alert-error-fill mb-2 w-fit rounded text-alert-error-base px-4 py-3">
            {{ Session('erro') }}
          </div>
        @endif


        <form method="post" action="/admin/registration/create/{{ $modalidade->id }}" class="w-full max-w-[700px]">
          @csrf
          <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
            <div class="flex flex-wrap gap-6 mb-6">
              <div class="grow sm:grow-0">
                <div class="group @error('cpf') error @enderror">
                  <div class="relative">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cpf_adicionar_atleta_form">
                      CPF
                    </label>
                    <input data-mask='cpf' required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="cpf_adicionar_atleta_form" name="cpf" value="{{ old('cpf') }}" placeholder="Ex.: 123.456.789-10" />

                    @error('cpf')
                      <div class="absolute bg-white top-[50%] right-3">
                        <img src="/images/svg/input-error.svg" alt="">
                      </div>
                    @enderror
                  </div>
                </div>
                @error('cpf')
                  <p class="text-input-error text-sm pt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="grow group @error('email') error @enderror">
                <div>
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="email_adicionar_atleta_form">
                    E-mail
                  </label>
                  <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="email_adicionar_atleta_form" name="email" value="{{ old('email') }}" placeholder="joao.silva@oab.org.br" />
                  @error('email')
                    <div class="absolute bg-white top-[50%] right-3">
                      <img src="/images/svg/input-error.svg" alt="">
                    </div>
                  @enderror
                </div>
                @error('email')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div class="mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_payment_field">
                Pagamento via
              </label>
              <div class="relative">
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="payment" id="cadastro_payment_field">
                  <option value="" selected  disabled>Selecione</option>
                  @foreach ($type_payments as $value)
                    <option value="{{ $value->id }}" >{{ $value->type }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>

            <div class="mb-6">
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_nascimento_field">
                Nascimento
              </label>
              <div class="relative">
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="date" id="cadastro_nascimento_field" value="{{ old('date_nasc') }}" name="date_nasc" />
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
                @if(request()->get('gender'))
                @if(request()->get('gender') == "M")
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sexo" id="cadastro_genero_field">
                  <option value="M" selected>Masculino</option>
                </select>
                @elseif(request()->get('gender') == "F")
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sexo" id="cadastro_genero_field">
                  <option value="F" selected>Feminino</option>
                </select>
                @endif
                @else
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sexo" id="cadastro_genero_field">
                  <option value="" @if (!old('sexo')) selected @endif disabled>Selecione</option>
                  <option value="M" @if (old('sexo') == 'M') selected @endif>Masculino</option>
                  <option value="F" @if (old('sexo') == 'F') selected @endif>Feminino</option>
                </select>
                @endif
                
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>

            <div class="grow mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="select_exemplo">
                Selecione a UF
              </label>
              <div class="relative max-w-[300px]">
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="uf" id="select_exemplo">
                  <option value="" @if (!old('uf')) selected @endif disabled>
                    Selecione
                  </option>
                  @foreach ($federative_units as $federative_unit)
                    <option value="{{ $federative_unit->id }}" @if (old('uf') == $federative_unit->id) selected @endif>{{ $federative_unit->initials }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
              @error('uf')
                <p class="text-danger">{{ $message }}</p>
              @enderror
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
            @if(request()->get('gender'))


              <div class="mb-6">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_category_field">
                  Selecione a categoria
                </label>
                <div class="relative">
                  <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="category" id="cadastro_category_field">
                    <option value="" selected  disabled>Selecione</option>
                    @foreach ($modalidade->modalities_categorys()->where('per_gender', request()->get('gender'))->get() as $category)
                      <option value="{{ $category->id }}" >{{ $category->nome }}</option>
                    @endforeach
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>



              @else
              <div class="mb-6">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_category_field">
                  Selecione a categoria
                </label>
                <div class="relative">
                  <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="category" id="cadastro_category_field">
                    <option value="" selected  disabled>Selecione</option>
                    @foreach ($modalidade->modalities_categorys as $category)
                      <option value="{{ $category->id }}" >{{ $category->nome }}</option>
                    @endforeach
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>

              @endif
            @endif

            @if (Count($modalidade->ranges) != 0)

              <div class="mb-6">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_range_field">
                  Selecione a faixa
                </label>
                <div class="relative">
                  <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="range" id="cadastro_range_field">
                    <option value="" selected  disabled>Selecione</option>
                    @foreach ($modalidade->ranges as $value)
                      <option value="{{ $value->id }}" >{{ $value->range }}</option>
                    @endforeach
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>
            @endif
            @if($modalidade->is_pcd)

              <div class="flex items-center gap-2 mb-3">
                <input type="checkbox" id="pcd_modalities" name="pcd" class="checkbox" />
                <label class="block pb-1 text-sm font-semibold text-brand-a1">
                  PCD
                </label>
              </div>


              <div id="sub_categorys_id" class="hidden">
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_sub_category_field">
                    Sub categoria
                  </label>
                  <div class="relative">
                    <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sub_category" id="cadastro_sub_category_field">
                      <option value="" selected disabled>Selecione</option>
                      @foreach ($sub_categorys as $value)
                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
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

@endsection
