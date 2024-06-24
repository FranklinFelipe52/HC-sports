@extends('PRF.base')

@section('title', 'HC Sports')

@section('content')

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <a target="_self" href="{{route('home')}}">
          <img src="{{asset('/images/logo-hc.png')}}" alt="">
        </a>
      </div>
    </header>

    <main class="container grow py-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="border border-gray-7 rounded-xl overflow-hidden">
          <div class="bg-brand-prfA1 border-b border-gray-7 flex justify-center items-center p-4 h-[153px]">
            <img src="{{asset('/images/PRF/Logo-Meia-PRF.png')}}" class="h-[100px]" alt="">
          </div>
          <div class="p-3.5 border-b border-gray-5">
            <p class="font-bold text-sm font-poppins mb-1 text-dark-1">
              Maratona da Polícia Federal
            </p>
            <p class="font-medium text-xs font-poppins text-gray-3">
              Natal, 11 de novembro de 2023
            </p>
          </div>
          <div class="px-3.5 py-3">
            <p class="font-bold text-sm font-poppins mb-1 text-gray-2">
              inscrições de 20/07 à 31/07
            </p>
          </div>
          <div class="px-3.5 pt-3 pb-4 flex justify-center">
            <a target="_self" href="/PRF" class="bg-brand-prfA1 hover:ring-opacity-50 hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
              Inscreva-se
            </a>
          </div>
        </div>
        <div class="border border-gray-7 rounded-xl overflow-hidden">
          <div class="bg-white border-b border-gray-7 flex justify-center items-center p-4 h-[153px]">
            <img src="{{asset('/images/logo-oab.png')}}" alt="">
          </div>
          <div class="p-3.5 border-b border-gray-5">
            <p class="font-bold text-sm font-poppins mb-1 text-dark-1">
              Jogos da OAB
            </p>
            <p class="font-medium text-xs font-poppins text-gray-3">
              Natal, 11 de novembro de 2023
            </p>
          </div>
          <div class="px-3.5 py-3">
            <p class="font-medium italic text-sm font-poppins mb-1 text-gray-3">
              inscrições encerradas
            </p>
          </div>
          <div class="px-3.5 pt-3 pb-4 flex justify-center">
            <a target="_self" href="/OAB/login" class="bg-brand-v2 hover:ring-opacity-50 hover:ring-2 transition-all hover:ring-brand-v2 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
              Acesse o Painel
            </a>
          </div>
        </div>
      </div>
    </main>

    @include('PRF.Components.footer')
  </div>

@endsection
