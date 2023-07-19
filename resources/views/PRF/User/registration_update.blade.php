
@extends('User.base')

@section('title', 'Perfil')

@section('profileClass', 'active')

@section('content')

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral');
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
              <div>
                <a href="{{ URL::previous() }}" class="text-xs text-gray-1 block hover:underline">
                  Inscrição
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                Alterar inscrição
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Alterar inscrição
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
          
          <div class="md:col-span-9 lg:col-span-10 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <form method="post">
                @csrf
              <div class="border border-gray-5 rounded-lg mb-6 p-4 sm:px-6 pb-6 space-y-6">
                <div>
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_text_exemplo">
                    Equipe
                  </label>
                  <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="input_text_exemplo" value="{{$registration->equipe}}" name="equipe" placeholder="Digite o nome da sua equipe" />
                </div>
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_size_tshirt_field">
                    Camiseta
                  </label>
                  <div class="relative">
                    <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="size_tshirt" id="inscricao_size_tshirt_field">
                      @foreach ( $shirts_sizes as $shirts_size )
                      <option @if($shirts_size == $registration->size_tshirt) @selected(true) @endif value="{{$shirts_size}}">{{$shirts_size}}</option>
                      @endforeach
                      
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_pace_field">
                    Pelotão
                  </label>
                  <div class="relative">
                    <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="pace" id="inscricao_pace_field">
                      @foreach ($paces as $pace)
                        <option @if( $pace->id == $registration->prf_pace_id) @selected(true) @endif value={{ $pace->id }}>{{ $pace->nome }}</option>
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_pace_field">
                    Distancia
                  </label>
                  <div class="relative">
                    <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="category" id="inscricao_category_field">
                      @foreach ($categorys as $category)
                        <option @if( $category->id == $registration->prf_categorys_id) @selected(true) @endif value={{ $category->id }}>{{ $category->nome }} (R$ {{ number_format( $category->price,2,",","."); }})</option>
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_pace_field">
                    Pacote
                  </label>
                  <div class="relative">
                    <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="package" id="inscricao_package_field">
                      @foreach ($packages as $package)
                        <option @if( $package->id == $registration->prf_package_id) @selected(true) @endif value={{ $package->id }}>{{ $package->nome }} (R$ {{ number_format($package->price,2,",","."); }})</option>
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                </div>
                <div class="col-12 border border-1">
                  <div class="d-flex flex-column gap-2">
                      @foreach ($tshirts as  $tshirt)
                      <div class="card m-4 flex-row p-3 " style="width: 25rem;">
                          <div class="form-check d-flex justify-content-center align-items-center">
                            
                            <input
                            @foreach ($registration->tshirts as $tshirt_registration )
                            @if( $tshirt_registration->id == $tshirt->id) @checked(true) @endif
                            @endforeach
                            class="form-check-input" type="checkbox" name="tshirts[]"  value="{{$tshirt->id}}" id="flexCheckDefault">
                          </div>
                          <div class="card-body">
                            <h5 class="card-title">{{$tshirt->nome}}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">itens incluídos: {{$tshirt->descricao}}</h6>
                            <p>R$ {{ number_format($tshirt->price,2,",","."); }}</p>
                          </div>
                        </div>
                      @endforeach
                  </div>
              </div>
              </div>
              <div class="flex gap-4 flex-wrap">
                <button type="submit" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
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
  </script>
  @endsection