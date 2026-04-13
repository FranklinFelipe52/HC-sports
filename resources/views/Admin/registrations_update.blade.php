@extends('Admin.base')

@section('title', $registration->modalities->nome . ' - Adicionar atleta na modalidade ')

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
          <form method="post" class="w-full max-w-[700px]">
            @csrf
            <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
              <div class="mb-6">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_payment_field">
                  Pagamento via
                </label>
                <div class="relative">
                  <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="payment" id="cadastro_payment_field">
                    <option value="" selected disabled>Selecione</option>
                    @foreach ($type_payments as $value)
                    @if($registration->type_payment->id == $value->id)
                      <option selected value="{{ $value->id }}">{{ $value->type }}</option>
                    @else
                    <option value="{{ $value->id }}">{{ $value->type }}</option>
                    @endif
                    @endforeach
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>

              <div class="mb-6">
                <p class="text-sm font-semibold text-gray-1 mb-4">
                  Modalidade de Interesse
                </p>

                <ul class="list-disc pl-10 text-gray-2 text-sm font-normal">
                  <li>
                    {{ $registration->modalities->nome }}
                  </li>
                </ul>
              </div>

              @if ($registration->modalities->mode_modalities->id == 3)
                @if (request()->get('gender'))

                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_category_field">
                      Selecione a categoria
                    </label>
                    <div class="relative">
                      <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="category" id="cadastro_category_field">
                        <option value="" selected disabled>Selecione</option>
                        @foreach ($registration->modalities->modalities_categorys()->where('per_gender', request()->get('gender'))->get() as $category)
                          @if($registration->modalities_category->id == $category->id)
                          <option selected value="{{ $category->id }}">{{ $category->nome }}</option>
                          @else
                          <option value="{{ $category->id }}">{{ $category->nome }}</option>
                          @endif
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
                        @foreach ($registration->modalities->modalities_categorys as $category)
                        @if($registration->modalities_category->id == $category->id)
                          <option selected value="{{ $category->id }}">{{ $category->nome }}</option>
                        @else
                          <option value="{{ $category->id }}">{{ $category->nome }}</option>
                        @endif
                        @endforeach
                      </select>
                      <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <img src="/images/svg/chevron-down.svg" alt="" />
                      </div>
                    </div>
                  </div>

                @endif
              @elseif($registration->modalities->mode_modalities->id == 2)
                <div>
                  @foreach ($registration->modalities->modalities_categorys as $category)
                 <?php $entry = false; ?>
                  @foreach ($registration->modalities_categorys as $value) 
                    @if($value->id == $category->id)
                    <div class="flex items-center gap-2 mb-3">
                      <input checked class="checkbox" type="checkbox" value="{{ $category->id }}" name="category[]" id="check-{{ $category->id }}">
                      <label class="block pb-1 text-sm font-semibold text-brand-a1" for="check-{{ $category->id }}">{{ $category->nome }}</label>
                    </div>
                    <?php $entry = true; ?>
                    @endif
                  @endforeach
                    @if(!$entry)
                  <div class="flex items-center gap-2 mb-3">
                    <input class="checkbox" type="checkbox" value="{{ $category->id }}" name="category[]" id="check-{{ $category->id }}">
                    <label class="block pb-1 text-sm font-semibold text-brand-a1" for="check-{{ $category->id }}">{{ $category->nome }}</label>
                  </div>
                  @endif
                  @endforeach
                </div>
              @endif
              @if (Count($registration->modalities->ranges) != 0)
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_range_field">
                    Selecione a faixa
                  </label>
                  <div class="relative">
                    <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="range" id="cadastro_range_field">
                      <option value="" selected disabled>Selecione</option>
                      @foreach ($registration->modalities->ranges as $value)
                      @if($registration->range->id == $value->id)
                        <option selected value="{{ $value->id }}">{{ $value->range }}</option>
                        @else
                        <option value="{{ $value->id }}">{{ $value->range }}</option>
                        @endif
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
              @endif
              @if ($registration->sub_categorys_id)
              
                <div >
                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_sub_category_field">
                      Sub categoria
                    </label>
                    <div class="relative">
                      <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="sub_category" id="cadastro_sub_category_field">
                        <option value="" selected disabled>Selecione</option>
                        @foreach ($sub_categorys as $value)
                        @if($registration->sub_categorys_id == $value->id)
                          <option selected value="{{ $value->id }}">{{ $value->nome }}</option>
                          @else
                          <option value="{{ $value->id }}">{{ $value->nome }}</option>
                          @endif
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
   


    if('{{ session('erro') }}') {
        showErrorToastfy('{{ session('erro') }}');
    }
    if('{{ session('success') }}') {
        showSuccessToastfy('{{ session('success') }}');
    }
    if('{{ session('edit_error') }}') {
        showErrorToastfy('{{ session('edit_error') }}');
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
