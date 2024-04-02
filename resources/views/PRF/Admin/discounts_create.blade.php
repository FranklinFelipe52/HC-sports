@extends('Admin.base')

@section('title', 'Descontos - Caminhada da Mãe Potiguar')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 1]) --}}

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 4])
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/admin/discounts" class="text-xs text-gray-1 block hover:underline">
                Códigos e descontodos
              </a>
            </div>
            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
              Cadastro de código
            </div>
          </nav>
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Cadastro de códigos
          </h1>
        </header>

        <form id="form_discounts" method="post" action="" class="w-full max-w-[700px]">
          @csrf
          <div class="border border-gray-5 p-4 sm:px-6 rounded-lg mb-6">
            <div class="w-full max-w-[230px] mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="select_desconto_modalidade">
                Modalidade
              </label>
              <div class="group relative">
                <select class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 text-sm placeholder:text-gray-500 appearance-none transition" id="select_desconto_modalidade">
                  <option value="criar_cupom" selected>Cupom de desconto</option>
                  <option value="criar_voucher">Voucher</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/PRF/svg/chevron-down.svg" class="group-[.disabled]:hidden" alt="" />
                  <img src="/images/svg/chevron-down-gray.svg" class="hidden group-[.disabled]:block" alt="" />
                </div>
              </div>
            </div>

            {{-- inputs caso a modalidade seja cupom --}}
            <div id="form_inputs_cupom">
              <div class="flex gap-6 mb-6">
                <div class="w-full max-w-[200px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="name_cupons_field">
                    Código
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 text-sm placeholder:text-gray-3 transition" type="text" id="name_cupons_field" name="code_cupom" placeholder="HCPROMO23" />
                </div>
                <div class="w-full max-w-[120px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="desconto_cupom_field">
                    Desconto (%)
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 text-sm placeholder:text-gray-3 transition" type="number" max="100" min="0" id="desconto_cupom_field" name="desconto_cupom" placeholder="0" />
                </div>
                <div class="w-full max-w-[232px]">
                  <label class="text-gray-1  font-semibold text-base inline-block mb-2" for="validade_cupom_field">
                    Validade
                  </label>
                  <div class="relative">
                    <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 text-sm placeholder:text-gray-3 transition" type="date" id="validade_cupom_field" name="validade_cupom" placeholder="DD/MM/AAAA" />
                    <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                      <img src="/images/PRF/svg/calendar.svg" alt="" />
                    </div>
                  </div>
                </div>
                {{-- <div class="w-full max-w-[120px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_text_exemplo">
                    Limite
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="number" max="100" min="0" id="desconto_cupom_field" name="desconto" placeholder="Desconto do cupom" />
                </div> --}}
              </div>
              <div class="flex gap-6 mb-6">
                <div class="w-full max-w-[400px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="descricao_cupom_field">
                    Descrição
                  </label>
                  <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="descricao_cupom_field" name="descricao_cupom" placeholder="Descrição do cupom" />
                </div>
              </div>
            </div>

            {{-- inputs caso a modalidade seja voucher --}}
            <div id="form_inputs_voucher" class="hidden">
              <div class="flex gap-6 mb-6">
                <div class="w-full max-w-[120px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="quantidade_vouchers_field">
                    Quantidade
                  </label>
                  <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="number" id="quantidade_vouchers_field" name="quant_voucher" placeholder="0" />
                </div>
                <div class="w-full max-w-[120px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="desconto_voucher_field">
                    Desconto (%)
                  </label>
                  <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="number" max="100" min="1" id="desconto_voucher_field" name="desconto_voucher" placeholder="0" />
                </div>
                <div class="w-full max-w-[232px]">
                  <label class="text-gray-1  font-semibold text-base inline-block mb-2" for="validade_voucher_field">
                    Validade
                  </label>
                  <div class="relative">
                    <input class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="date" id="validade_voucher_field" name="validade_voucher" placeholder="DD/MM/AAAA" />
                    <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                      <img src="/images/PRF/svg/calendar.svg" alt="" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex gap-6 mb-6">
                <div class="w-full max-w-[400px]">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="descricao_cupom_field">
                    Descrição
                  </label>
                  <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="descricao_cupom_field" name="descricao_voucher" placeholder="Descrição do voucher" />
                </div>
              </div>
            </div>
          </div>
          <div class="flex gap-6">
            <button type="submit" class="order-1 sm:order-2 flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 transition">
              <p class="text-white text-sm font-bold font-poppins">
                Gerar
              </p>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

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

    const form_discounts = document.querySelector('#form_discounts');
    const form_inputs_voucher = form_discounts.querySelector('#form_inputs_voucher');
    const form_inputs_cupom = form_discounts.querySelector('#form_inputs_cupom');
    const selectedModalidade = form_discounts.querySelector('#select_desconto_modalidade');

    form_discounts.addEventListener('submit', handleFormSubmit);
    selectedModalidade.addEventListener('change', handleSelectChange);

    function handleSelectChange(e) {
      if (e.target.value == 'criar_cupom') {
        form_inputs_voucher.classList.add('hidden');
        form_inputs_cupom.classList.remove('hidden');

        form_inputs_cupom.querySelectorAll('input').forEach((input) => {
          input.setAttribute('required', 'required');
        });

        form_inputs_voucher.querySelectorAll('input').forEach((input) => {
          input.removeAttribute('required');
        });

      } else if (e.target.value == 'criar_voucher') {
        form_inputs_cupom.classList.add('hidden');
        form_inputs_voucher.classList.remove('hidden');

        form_inputs_voucher.querySelectorAll('input').forEach((input) => {
          input.setAttribute('required', 'required');
        });

        form_inputs_cupom.querySelectorAll('input').forEach((input) => {
          input.removeAttribute('required');
        });
      }
    }

    function handleFormSubmit(e) {
      e.preventDefault();

      form_discounts.action = `/admin/${selectedModalidade.value}`;

      form_discounts.submit();
    }
  </script>
@endsection
