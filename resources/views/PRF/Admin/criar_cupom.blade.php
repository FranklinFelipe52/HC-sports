@extends('PRF.base')

@section('title', 'Criar cupom - Meia Maratona PRF')

@section('content')

  <div class="lg:grid lg:grid-cols-7 xl:container">
    <div class="lg:sticky lg:top-0 lg:h-screen max-h-[1200px] lg:col-span-3 bg-white bg-[url('/images/PRF/background.png')] bg-cover bg-no-repeat">
      <div class="flex flex-col h-full">
        <header class="p-5">
          <a href="/admin/dashboard">
            <img src="/images/PRF/Logo-Meia-PRF.png" class="h-[100px]"  alt="" />
          </a>
        </header>
        <div class="p-8 pb-12 lg:p-8 my-auto">
          <div class="w-fit">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-semibold text-brand-prfA1 font-poppins">
                Criar cupom
            </h1>
            <div class="bg-brand-prfA1 h-1 rounded-lg mt-3.5 mb-2 w-1/2"></div>
          </div>
          {{-- <p class="text-sm font-normal text-gray-1">
            Gere cupoms
          </p> --}}
        </div>
        <div class="hidden lg:block p-8"></div>
        <div class="mx-auto pb-8 lg:p-0 lg:absolute lg:top-1/2 lg:-right-6 hidden lg:block">
          <a href="#gerar_cupom_form" class="bg-dark-400 w-12 h-12 flex justify-center items-center rounded-full rotate-90 lg:rotate-0">
            <img src="/images/svg/chevron-left-fill.svg" alt="" />
          </a>
        </div>
      </div>
    </div>
    <div class="bg-white h-full lg:col-span-4 px-8 py-20  flex flex-col justify-center">
      <div class="mx-auto w-full max-w-[327px]">
        <form id="gerar_cupom_form" method="post" class="mb-4">
          @csrf
          <div class="space-y-4 mb-6">
            <div class="group @error('name') error @enderror">
              <div class="relative">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="name_cupons_field">
                  Código
                </label>
                <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="name_cupons_field" name="code" placeholder="Código do cupom" />
              </div>
            </div>
            <div class="group @error('descricao') error @enderror">
              <div class="relative">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="descricao_cupom_field">
                  Descrição
                </label>
                <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="descricao_cupom_field" name="descricao" placeholder="Descrição do cupom" />
              </div>
            </div>
            <div class="group @error('desconto') error @enderror">
              <div class="relative">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="desconto_cupom_field">
                  Desconto
                </label>
                <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="number" max="100" min="0" id="desconto_cupom_field" name="desconto" placeholder="Desconto do cupom" />
              </div>
            </div>
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="validade_cupom_field">
                Validade
              </label>
              <div class="relative">
                <input class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="date" id="validade_cupom_field" name="validade" placeholder="DD/MM/AAAA" />
                <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                  <img src="/images/PRF/svg/calendar.svg" alt="" />
                </div>
              </div>
            </div>
          </div>
          <button id="submit_button" data-conditional-button type="submit" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
            <p class="text-white text-sm font-bold font-poppins">
              Criar cupom
            </p>
          </button>
        </form>

      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/js/app.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    const code = document.getElementById("name_cupons_field");
    new Cleave('#name_cupons_field', {
      uppercase: true,
      blocks: [16],
      delimiters: [''],
      onValueChanged: function (e) {
        code.value = e.target.value.replace(/\s/g, '');
    }
    });
    console.log('teste');
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
  </script>
@endsection