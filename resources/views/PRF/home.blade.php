@extends('PRF.base')

@section('title', 'Corrida da Água')

@section('content')

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <div class="flex justify-between">
          <a href="/">
            <img src="/images/CAERN/Logo-CORRIDA-CAERN.png" width="200" alt="">
          </a>
          <div class="flex gap-4">
            <div class="flex items-center justify-center">
              <a href="/login" style="text-align: center;" class="font-semibold border border-brand-prfA1 rounded-md px-3.5 py-2 text-brand-prfA1 hover:text-white hover:bg-brand-prfA1 transition-all">
                Acesse seu cadastro
              </a>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main class="container grow pt-6 pb-32">
      
      <img src="/images/CAERN/Testeira-566.png" class="md:hidden w-full" alt="">
      <img src="/images/CAERN/Testeira-876.png" class="hidden md:block lg:hidden w-full" alt="">
      <img src="/images/CAERN/Testeira-1130.png" class="hidden lg:block w-full" alt="">

      <div class="grid grid-cols-1 lg:grid-cols-2 pt-8 gap-6">
        <div class="order-2 lg:order-1">
          <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-1 mb-6">
              A Corrida
            </h2>

            <div class="space-y-4 text-gray-1 text-sm">
              <p>
                A Corrida da Água – CAERN é uma iniciativa da HC Sports em parceria com a Federação Norteriograndense de Atletismo e o patrocínio Master da CAERN – Companhia de Águas e Esgotos do Rio Grande do Norte.
              </p>

              <p>
                A corrida faz parte das comemorações do Dia Mundial da Água. A prova tem o objetivo de alertar as pessoas sobre a importância de preservar o recurso da natureza.
              </p>

              <p>
                A prova contará com distâncias de 12Km e 6Km e será realizada no dia 23 de março de 2025, com largada e chegada na Assec – Associação dos Servidores da CAERN. O horário de largada será distribuído da seguinte forma:
              </p>

              <ul class="list-disc pl-4">
                <li>
                  Categorias PCD | GERAL: 12Km – 16h00;
                </li>
                <li>
                  Categorias PCD | GERAL: 6Km – 16h10.
                </li>
              </ul>

              <p>
                Acesse <a href="https://corridadaagua.com.br/" class="text-blue-600 underline">corridadaagua.com.br</a> e leia atentamente o Regulamento da Prova.
              </p>
            </div>
          </div>

          {{-- <div>
            <h3 class="text-base font-bold text-gray-1 mb-6">
              Fotos
            </h3>

            <div class="grid grid-rows-1 grid-cols-2 md:grid-cols-4 gap-4">
              <div class="row-span-1 col-span-1 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-1.jpg" class="w-full h-full object-cover" alt="">
              </div>
              <div class="row-span-1 col-span-1 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-2.png" class="w-full h-full object-cover" alt="">
              </div>
              <div class="md:row-span-2 md:col-span-2 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-4.jpg" class="w-full h-full object-cover" alt="">
              </div>
              <div class="row-span-1 md:col-span-2 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-3.jpg" class="w-full h-full object-cover" alt="">
              </div>
            </div>
          </div> --}}
        </div>
        <div class="order-1 lg:order-2">
          <h1 class="text-xl font-bold text-gray-1 mb-6">
            Opções de inscrição
          </h1>
          <div class="space-y-4">
            @foreach ($categorys->reverse() as $category)
              @foreach ($packages as $package)
                <div class="border border-gray-5 px-3.5 py-4 rounded-lg">
                  <div class="flex flex-wrap justify-between">
                    <div class="mb-3.5">
                      <p class="font-semibold text-gray-1 text-base">
                        {{ $package->nome }} {{ $category->nome }}
                      </p>
                    </div>
                    <div class="">
                      <p class="text-brand-v1 text-1.5xl w-full text-end">
                        <span class="text-sm">
                          R$
                        </span>
                        {{ number_format($category->price, 2, ',', '.') }}
                      </p>
                    </div>
                  </div>
                  <div class="flex flex-wrap justify-between items-end gap-4">
                    <div class="">
                      <p class="font-normal text-xs text-gray-1 mb-3.5">
                        Itens inclusos
                      </p>
                      <div class="text-gray-1 text-xs font-bold list__options">
                        {!! html_entity_decode($package->descricao) !!}
                      </div>
                    </div>
                    <div>
                      {{--<a href="/inscricao/{{ $category->id }}/{{ $package->id }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
                        Inscrições Encerradas
                      </a>--}}
                      <a  class="bg-gray-500 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
                        INSCRIÇÕES ENCERRADAS
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            @endforeach
          </div>
        </div>
      </div>
    </main>

    @include('PRF.Components.footer')
  </div>
@endsection
