
@extends('User.base')

@section('title', 'Pagamento - cartão')

@section('profileClass', 'active')

@section('content')

  
  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
    @include('components.header');
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
              <div>
                <a href="/" class="text-xs text-gray-1 block hover:underline">
                  Dashboard
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div>
                <a href="/checkout/{{$registration->id}}" class="text-xs text-gray-1 block hover:underline">
                  Método de pagamento
                </a>
              </div>
              <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                Dados do cartão
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Dados do Cartão de Crédito
            </h1>
          </div>
        </header>
        @if (Session::has('erro'))
<div class="alert alert-danger" role="alert">
    {{Session('erro')}}
</div>
@endif

        <!-- conteúdo -->
        <div class="container w-full">
          <form id="form-card" action="/card/{{$registration->id}}" method="post" class="w-full max-w-[600px]">
            @csrf
            <input id="token_card" name="token_card"  type="hidden" value="">
            <div class="border border-gray-5 p-6 rounded-lg mb-6 space-y-6">
              <div class="group ">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="numero_cartao_pagamento">
                  Número do cartão
                </label>
                <div class="relative max-w-[330px]">
                  
                  <input id="numberCard" name="numberCard" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" placeholder="0000 0000 0000 0000" />
                  <div class="absolute right-4 top-4 bg-white pl-2">
                    <img src="/images/svg/credit-card-gray.svg" class="group-[.error]:hidden" alt="">
                    <img src="/images/svg/credit-card-error.svg" class="hidden group-[.error]:block" alt="">
                  </div>
                </div>
                <p class="text-input-error mt-2 text-sm hidden group-[.error]:block">
                  Lorem ipsum dolor sit amet.
                </p>
              </div>
              <div class="group ">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="nome_cartao_pagamento">
                  Nome no cartão
                </label>
                <div class="relative max-w-[330px]">
                  <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" id="nome" name="nome" placeholder="Digite o nome que está no cartão" />
                  <div class="absolute right-2 top-2 bg-white pl-2">
                    <img src="/images/svg/input-error.svg" class="hidden group-[.error]:block" alt="">
                  </div>
                </div>
                <p class="text-input-error mt-2 text-sm hidden group-[.error]:block">
                  Lorem ipsum dolor sit amet.
                </p>
              </div>
              <div class="group ">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="data_cartao_pagamento">
                Mês de expiração
                </label>
                <div class="relative max-w-[160px]">
                  <input id="expMonth" name="expMonth" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" placeholder="00" />
                  <div class="absolute right-2 top-2 bg-white pl-2">
                    <img src="/images/svg/input-error.svg" class="hidden group-[.error]:block" alt="">
                  </div>
                </div>
                <p class="text-input-error mt-2 text-sm hidden group-[.error]:block">
                  Lorem ipsum dolor sit amet.
                </p>
              </div>

              <div class="group ">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="data_cartao_pagamento">
                Ano de expiração
                </label>
                <div class="relative max-w-[160px]">
                  <input id="expYear" name="expYear" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" placeholder="0000" />
                  <div class="absolute right-2 top-2 bg-white pl-2">
                    <img src="/images/svg/input-error.svg" class="hidden group-[.error]:block" alt="">
                  </div>
                </div>
                <p class="text-input-error mt-2 text-sm hidden group-[.error]:block">
                  Lorem ipsum dolor sit amet.
                </p>
              </div>


              <div class="group ">
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cvv_pagamento">
                  CVV
                </label>
                <div class="relative max-w-[160px]">
                  <input id="cvv" name="cvv" class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 group-[.error]:border-input-error group-[.error]:outline-input-error text-gray-1 placeholder:text-gray-3 transition" type="text" placeholder="000" />
                  <div class="absolute right-2 top-2 bg-white pl-2">
                    <img src="/images/svg/input-error.svg" class="hidden group-[.error]:block" alt="">
                  </div>
                </div>
                <p class="text-input-error mt-2 text-sm hidden group-[.error]:block">
                  Lorem ipsum dolor sit amet.
                </p>
              </div>
              <hr class="border-gray-5">
              
              <!--<div>
                <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="select_exemplo">
                  Parcelamento
                </label>
                <div class="relative w-full max-w-[240px]">
                  <select class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="select_exemplo" id="select_exemplo">
                    <option selected value="1">1x de R$ 150,00</option>
                    <option value="2">2x de R$ 80,00</option>
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>
              -->
              <hr class="border-gray-5">
              <div>
                <p class="text-gray-1 font-semibold text-sm mb-1">
                  Valor total da compra
                </p>
                <p class="text-gray-1 font-normal text-sm">
                R${{$value_payment}}
                </p>
              </div>
            </div>
            <div class="flex flex-wrap-reverse gap-y-6 justify-between">
              <button id="submitCheckout" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                <img src="/images/svg/credit-card-outline.svg" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Efetuar pagamento
                </p>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://assets.pagseguro.com.br/checkout-sdk-js/rc/dist/browser/pagseguro.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
new Cleave('#numberCard', {
    creditCard: true
});

new Cleave('#expMonth', {
    date: true,
    datePattern: ['m']
});
new Cleave('#expYear', {
    date: true,
    datePattern: ['Y']
});

const cardCCV = new Cleave("#cvv", {
    numeral: true,
    stripLeadingZeroes: false,
    onValueChanged: function(e) {
        const maxSize = 3;
        if (e.target.rawValue.length > maxSize) {
            cardCCV.setRawValue(e.target.rawValue.substring(0, maxSize));
        }
    },
});
var numberCard = document.getElementById('numberCard');
var nome = document.getElementById('nome');
var expMonth = document.getElementById('expMonth');
var expYear = document.getElementById('expYear');
var cvv = document.getElementById('cvv');
document.getElementById('submitCheckout').addEventListener('click', (e)=>{
    e.preventDefault();
    var card = PagSeguro.encryptCard({
    publicKey: "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr+ZqgD892U9/HXsa7XqBZUayPquAfh9xx4iwUbTSUAvTlmiXFQNTp0Bvt/5vK2FhMj39qSv1zi2OuBjvW38q1E374nzx6NNBL5JosV0+SDINTlCG0cmigHuBOyWzYmjgca+mtQu4WczCaApNaSuVqgb8u7Bd9GCOL4YJotvV5+81frlSwQXralhwRzGhj/A57CGPgGKiuPT+AOGmykIGEZsSD9RKkyoKIoc0OS8CPIzdBOtTQCIwrLn2FxI83Clcg55W8gkFSOS6rWNbG5qFZWMll6yl02HtunalHmUlRUL66YeGXdMDC2PuRcmZbGO5a/2tbVppW6mfSWG3NPRpgwIDAQAB",
    holder: nome.value,
    number: numberCard.value.replace(/\s/g, ''),
    expMonth: expMonth.value,
    expYear: expYear.value,
    securityCode: cvv.value
});
console.log(card.encryptedCard);
if(card.hasErrors){
    console.log(card);
    alert("por favor, digite um cartão valido");
} else {
    document.getElementById("token_card").setAttribute('value', card.encryptedCard);
    document.getElementById("form-card").submit();
}
});
</script>
  @endsection
  
