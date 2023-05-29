@extends('Admin.base')

@section('title', $modalidade->nome . ' - Adicionar atleta na modalidade ')

@section('content')

  @include('components.admin.menu_mobile', ['type' => 1])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 1]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('admin')->personification)
        @include('components.admin.personification_nav')
      @endif
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="container pt-8 pb-6 space-y-6">
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

        <div class="container">
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
                      <input data-cpf required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="cpf_adicionar_atleta_form" name="cpf" value="{{ old('cpf') }}" placeholder="Ex.: 123.456.789-10" />

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
                    <input data-preload="email-visible" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="email_adicionar_atleta_form" name="email" value="{{ old('email') }}" placeholder="exemplo@oab.org.br" />
                    {{-- <input data-preload="email" class="hidden" type="email" id="email_adicionar_atleta_form" name="email" value="{{ old('email') }}" /> --}}
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
                    <option value="" selected disabled>Selecione</option>
                    @foreach ($type_payments as $value)
                      <option value="{{ $value->id }}">{{ $value->type }}</option>
                    @endforeach
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>

              <div class="mb-6">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_phone_field">
                  Celular
                </label>
                <input data-preload="celular-visible" required placeholder="Ex: (00) 0 0000-0000" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" name="phone_number" type="text" id="celular_adicionar_atleta_form" />
              </div>

              <div class="mb-6">
                <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_nascimento_field">
                  Nascimento
                </label>
                <div class="relative">
                  <input data-preload="data_nasc-visible" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3 transition" type="date" id="cadastro_nascimento_field" value="{{ old('date_nasc') }}" name="date_nasc" />
                  {{-- <input data-preload="data_nasc" class="hidden" type="date" id="cadastro_nascimento_field" value="{{ old('date_nasc') }}" name="date_nasc" /> --}}
                  <div class="pointer-events-none absolute top-4 right-4 bg-white">
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
                  @if (request()->get('gender'))
                    @if (request()->get('gender') == 'M')
                      <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sexo" id="cadastro_genero_field">
                        <option value="M" selected>Masculino</option>
                      </select>
                    @elseif(request()->get('gender') == 'F')
                      <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sexo" id="cadastro_genero_field">
                        <option value="F" selected>Feminino</option>
                      </select>
                    @endif
                  @else
                    <select data-preload="sexo-visible" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 appearance-none transition" name="sexo" id="cadastro_genero_field">
                      <option value="" @if (!old('sexo')) selected @endif disabled>Selecione</option>
                      <option value="M" @if (old('sexo') == 'M') selected @endif>Masculino</option>
                      <option value="F" @if (old('sexo') == 'F') selected @endif>Feminino</option>
                    </select>
                    {{-- <select data-preload="sexo" class="hidden" name="sexo" id="cadastro_genero_field">
                      <option value="" @if (!old('sexo')) selected @endif disabled>Selecione</option>
                      <option value="M" @if (old('sexo') == 'M') selected @endif>Masculino</option>
                      <option value="F" @if (old('sexo') == 'F') selected @endif>Feminino</option>
                    </select> --}}
                  @endif

                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>
              @if (Session('admin')->rule->id == 1)
                <div class="grow mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="select_exemplo">
                    Selecione a UF
                  </label>
                  <div class="relative max-w-[300px]">
                    <select data-preload="uf-visible" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 appearance-none transition" name="uf" id="select_exemplo">
                      <option value="" @if (!old('uf')) selected @endif disabled>
                        Selecione
                      </option>
                      @foreach ($federative_units as $federative_unit)
                        <option value="{{ $federative_unit->id }}" @if (old('uf') == $federative_unit->id) selected @endif>{{ $federative_unit->initials }}</option>
                      @endforeach
                    </select>
                    {{-- <select data-preload="uf" required class="hidden" name="uf" id="select_exemplo">
                      <option value="" @if (!old('uf')) selected @endif disabled>
                        Selecione
                      </option>
                      @foreach ($federative_units as $federative_unit)
                        <option value="{{ $federative_unit->id }}" @if (old('uf') == $federative_unit->id) selected @endif>{{ $federative_unit->initials }}</option>
                      @endforeach
                    </select> --}}
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                  @error('uf')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>

              @endif

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

              @if ($modalidade->mode_modalities->id == 3)
                @if (request()->get('gender'))


                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_category_field">
                      Selecione a categoria
                    </label>
                    <div class="relative">
                      <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="category" id="cadastro_category_field">
                        <option value="" selected disabled>Selecione</option>
                        @foreach ($modalidade->modalities_categorys()->where('per_gender', request()->get('gender'))->get() as $category)
                          <option value="{{ $category->id }}">{{ $category->nome }}</option>
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
                        <option value="" selected disabled>Selecione</option>
                        @foreach ($modalidade->modalities_categorys as $category)
                          <option value="{{ $category->id }}">{{ $category->nome }}</option>
                        @endforeach
                      </select>
                      <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <img src="/images/svg/chevron-down.svg" alt="" />
                      </div>
                    </div>
                  </div>

                @endif
              @elseif($modalidade->mode_modalities->id == 2)
                <div>
                  @foreach ($modalidade->modalities_categorys as $category)
                    <div class="flex items-center gap-2 mb-3">
                      <input class="checkbox" type="checkbox" value="{{ $category->id }}" name="category[]" id="check-{{ $category->id }}">
                      <label class="block pb-1 text-sm font-semibold text-brand-a1" for="check-{{ $category->id }}">{{ $category->nome }}</label>
                    </div>
                  @endforeach
                </div>
              @endif
              @if (Count($modalidade->ranges) != 0)
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_range_field">
                    Selecione a faixa
                  </label>
                  <div class="relative">
                    <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="range" id="cadastro_range_field">
                      <option value="" selected disabled>Selecione</option>
                      @foreach ($modalidade->ranges as $value)
                        <option value="{{ $value->id }}">{{ $value->range }}</option>
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
              @endif
              @if ($modalidade->is_pcd)
                <div class="flex items-center gap-2 mb-3">
                  <input data-preload="pcd-visible" type="checkbox" id="pcd_modalities" name="pcd" class="checkbox" />
                  <input data-preload="pcd" type="checkbox" id="pcd_modalities" name="pcd" class="hidden" />
                  <label class="block pb-1 text-sm font-semibold text-brand-a1" for="pcd_modalities" id="label-pcd">
                    PCD
                  </label>
                </div>
                <div id="sub_categorys_id" class="hidden">
                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_sub_category_field">
                      Sub categoria
                    </label>
                    <div class="relative">
                      <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sub_category" id="cadastro_sub_category_field">
                        <option value="" selected disabled>Selecione</option>
                        <option value="1">sub categoria 1</option>
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
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="module" src="/js/app.js"></script>
  <script type="module">
    new Cleave('#cpf_adicionar_atleta_form', {
      blocks: [3, 3, 3, 2],
      delimiters: ['.', '.', '-'],
      numericOnly: true,
    });

    new Cleave('#celular_adicionar_atleta_form', {
      blocks: [2, 1, 4, 4],
      delimiters: [' ', ' ', '-'],
      numericOnly: true,
    });


    if('{{ session('erro') }}') {
        showErrorToastfy('{{ session('erro') }}');
    }
    if('{{ session('success') }}') {
        showSuccessToastfy('{{ session('success') }}');
    }
    if('{{ session('edit_error') }}') {
        showErrorToastfy('{{ session('edit_error') }}');
    }

    const inputCpf = document.querySelector('[data-cpf]');

    const inputEmailVisible = document.querySelector('[data-preload="email-visible"]');
    // const inputEmail = document.querySelector('[data-preload="email"]');

    const inputDataNascVisible = document.querySelector('[data-preload="data_nasc-visible"]');
    // const inputDataNasc = document.querySelector('[data-preload="data_nasc"]');

    const inputSexoVisible = document.querySelector('[data-preload="sexo-visible"]');
    // const inputSexo = document.querySelector('[data-preload="sexo"]');

    const inputUfVisible = document.querySelector('[data-preload="uf-visible"]');
    // const inputUf = document.querySelector('[data-preload="uf"]');

    const inputCelularVisible = document.querySelector('[data-preload="celular-visible"]');
    // const inputCelular = document.querySelector('[data-preload="celular"]');

    const inputPcdVisible = document.querySelector('[data-preload="pcd-visible"]');
    // const inputPcd = document.querySelector('[data-preload="pcd"]');
    // const labelPcd = document.querySelector('#label-pcd');

    const urlParams = new URLSearchParams(window.location.search);
    const gender = urlParams.get('gender');

    inputCpf.focus();

    function clearInputs() {
      inputEmailVisible.value = '';
      // inputEmail.value = '';

      inputDataNascVisible.value = '';
      // inputDataNasc.value = '';

      if (inputSexoVisible) {
        inputSexoVisible.value = '';
        // inputSexo.value = '';
      }

      inputCelularVisible.value = '';

      inputUfVisible.value = '';
      // inputUf.value = '';

      if (inputPcdVisible) {
        inputPcdVisible.checked = false;
        // inputPcd.checked = false;
      }
    }

    /* function disableInputs() {
      inputEmailVisible.disabled = true;
      inputEmail.disabled = false;

      inputDataNascVisible.disabled = true;
      inputDataNasc.disabled = false;

      if (inputSexo && inputSexoVisible) {
        inputSexoVisible.disabled = true;
        inputSexo.disabled = false;
      }

      inputUfVisible.disabled = true;
      inputUf.disabled = false;

      if (inputPcdVisible && inputPcd) {
        inputPcdVisible.disabled = true;
        inputPcd.disabled = false;
        labelPcd.style.filter = 'grayscale(1)';
      }
    }

    function enableInputs() {
      inputEmailVisible.disabled = false;
      inputEmail.disabled = true;

      inputDataNascVisible.disabled = false;
      inputDataNasc.disabled = true;

      if (inputSexo && inputSexoVisible) {
        inputSexoVisible.disabled = false;
        inputSexo.disabled = true;
      }

      inputUfVisible.disabled = false;
      inputUf.disabled = true;

      if (inputPcdVisible && inputPcd) {
        inputPcdVisible.disabled = false;
        inputPcd.disabled = true;
        labelPcd.style.filter = 'none';
      }
    } */

    // disableInputs();
    // clearInputs();

    inputCpf.addEventListener('input', () => {
      const cpf = inputCpf.value.replace(/[^\d]/g, ''); // Remova caracteres não numéricos

      if (cpf.length === 11) {
        fetch(`/api/user/${cpf}`)
          .then(response => response.json())
          .then(data => {
            // disableInputs();

            console.log(data);

            if (gender && data[0]['sexo'] === gender) {
              inputEmailVisible.value = data[0]['email'];
              // inputEmail.value = data[0]['email'];

              inputDataNascVisible.value = data[0]['data_nasc'];
              // inputDataNasc.value = data[0]['data_nasc'];

              if (inputSexoVisible) {
                inputSexoVisible.value = data[0]['sexo'];
                // inputSexo.value = data[0]['sexo'];
              }

              inputUfVisible.value = data[0]['federative_unit_id'];
              // inputUf.value = data[0]['federative_unit_id'];

              inputCelularVisible.value = data[0]['phone_number'];

              if (inputPcdVisible) {
                inputPcdVisible.checked = data[0]['is_pcd'] ? true : false
                // inputPcd.checked = data[0]['is_pcd'] ? true : false

                if (inputPcd.checked) {
                  isPcd();
                }
              };

              showSuccessToastfy("Ótimo! Esse atleta já possui cadastro. Iremos carregar os dados automaticamente");
            } else if (!gender) {
              inputEmailVisible.value = data[0]['email'];
              // inputEmail.value = data[0]['email'];

              inputDataNascVisible.value = data[0]['data_nasc'];
              // inputDataNasc.value = data[0]['data_nasc'];

              if (inputSexoVisible) {
                inputSexoVisible.value = data[0]['sexo'];
                // inputSexo.value = data[0]['sexo'];
              }

              inputUfVisible.value = data[0]['federative_unit_id'];
              // inputUf.value = data[0]['federative_unit_id'];

              inputCelularVisible.value = data[0]['phone_number'];

              if (inputPcdVisible) {
                inputPcdVisible.checked = data[0]['is_pcd'] ? true : false
                // inputPcd.checked = data[0]['is_pcd'] ? true : false

                if (inputPcd.checked) {
                  isPcd();
                }
              };

              showSuccessToastfy("Ótimo! Esse atleta já possui cadastro. Iremos carregar os dados automaticamente");
            } else {
              clearInputs();
              showErrorToastfy("Este cpf pertence a um usuário incompatível com essa modalidade");
            }
          })
          .catch(error => {
            // clearInputs();
            // enableInputs();
            console.error(error);
          });
      } else {
        // clearInputs();
        // disableInputs();
      }
    });

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

    const pcd_checkbox = document.getElementById("pcd_modalities");
    const sub_category_box = document.getElementById("sub_categorys_id");
    const sub_categorys_select = document.getElementById(
      "cadastro_sub_category_field"
    );

    try {
      pcd_checkbox.addEventListener("click", handleToggleCheckbox);
    } catch (e) {

    }

    function isPcd() {
      sub_category_box.classList.remove("hidden");
      sub_categorys_select.required = true;

      sub_categorys_select.scrollIntoView({
        behavior: "smooth"
      });
    }

    function isNotPcd() {
      sub_category_box.classList.add("hidden");
      sub_categorys_select.required = false;
    }

    function handleToggleCheckbox({
      currentTarget
    }) {
      if (currentTarget.checked) {
        isPcd();
      } else {
        isNotPcd();
      }
    }
  </script>

@endsection
