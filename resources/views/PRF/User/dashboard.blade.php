@extends('PRF.user.base')

@section('title', 'Dashboard')

@section('homeClass', 'active')

@section('content')

<style>
  li{
    font-size: 14px;
  }
</style>
<!-- grid principal -->
<div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

  <!-- Menu lateral -->
  <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
    @include('PRF.components.header');
  </div>

  <!-- corpo da página -->
  <div class="order-1 sm:order-2 overflow-hidden">
    <div class="h-full w-full flex flex-col overflow-auto pb-8">

      <!-- Cabeçalho -->
      <header class="pt-8 pb-6 space-y-6">
        <div class="container">
          
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Inscrições realizadas
          </h1>
        </div>
      </header>


      <div class="container">
        <div class="row">
          @foreach ($registrations as $registration)
          <div class="col-4">
            <div class="card m-4 border border-1 p-3" style="width: 18rem;">
              <div class="card-body">
                <div class="flex flex-row justify-between mb-4">
                  <h5 class="card-title">{{$registration['title']}} </h5>
                  <div class="@if ($registration['status_registration']->id == 1) bg-feedback-green-1 @elseif ($registration['status_registration']->id == 3) bg-feedback-purple @endif  py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                    <p class="text-white text-[0.5rem] font-bold text-center">
                      {{ $registration['status_registration']->status }}
                    </p>
                  </div>
                </div>
                <p>R$ {{ number_format($registration['pricePackage'],2,",","."); }} {{$registration['priceTshirts'] != 0 ? ' + '.$registration['priceTshirts'] : '' }}</p>
                <h6 class="card-subtitle mb-2 text-body-secondary">itens inclusos</h6>
                {!! html_entity_decode($registration['descricao']) !!}
                <h6 class="card-subtitle mb-2 text-body-secondary">Camiseta: {{ $registration['size_tshirt']}}</h6>
                <h6 class="card-subtitle mb-2 text-body-secondary">Equipe: {{ $registration['equipe']}}</h6>
                <h6 class="card-subtitle mb-2 text-body-secondary">Pelotão: {{ $registration['pace']}}</h6>
                <button  onclick="window.open('/PRF/checkout/{{$registration['id']}}', '_self')" class="text-xs font-semibold text-white bg-brand-a1 grow p-2 rounded border border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 disabled:text-gray-1 disabled:hover:ring-0 disabled:border-gray-1 disabled:opacity-50 disabled:cursor-not-allowed transition">
                  Realizar Pagamento
                </button>
              </div>
            </div>
          </div>
         
      @endforeach
      </div>
      </div>
      <!-- conteúdo -->
      
    
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


