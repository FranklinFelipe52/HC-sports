@extends('PRF.base')

@section('title', 'Circuito Dunas 2026')

@section('content')
  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <div class="flex gap-3 flex-wrap justify-center md:justify-between">
          <a href="/">
            <img src="/images/CAERN/logo.png" width="200" alt="">
          </a>
          
            <div class="flex items-center flex-wrap justify-center w-full md:w-auto gap-3">
              <a href="/login" style="text-align: center;" class="font-semibold border border-brand-prfA1 rounded-md px-3.5 py-2 text-brand-prfA1 hover:text-white hover:bg-brand-prfA1 transition-all">
                Acesse seu cadastro
              </a>
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
                A 2ª edição do Circuito Dunas 2026 vem aí! 🏃‍♂️💨
              </p>

              <p>
                A corrida da Arena que já é sucesso, agora reforça ainda mais seu propósito: promover saúde, bem-estar e qualidade de vida para todos os funcionários e colaboradores.
              </p>

              <p>
                A CIPA (Comissão Interna de Prevenção de Acidentes) é responsável por desenvolver ações que garantem mais segurança e saúde no ambiente de trabalho e o Circuito Dunas é um reflexo desse cuidado com as pessoas.
              </p>

              <p>
                Prepare-se para mais um momento de energia e movimento!
              </p>

              <ul class="space-y-1 pt-1">
                <li>📍 Dia 30 de abril (Quinta-feira)</li>
                <li>⏰ Às 16h</li>
                <li>📌 Casa de Apostas Arena das Dunas</li>
              </ul>
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

          <div class="space-y-4 mb-3">
            @foreach ($categorys_geral->reverse() as $category)
              @foreach ($packages as $package)
                <div class="border border-gray-5 px-3.5 py-4 rounded-lg">
                  <div class="flex flex-wrap justify-between">
                    <div class="mb-3.5">
                      <p class="text-gray-1 font-bold text-lg">
                        {{ $category->nome }}
                      </p>
                    </div>
                    <div class="">
                      <p class="text-brand-prfA1 text-1.5xl w-full text-end font-bold">
                        Gratuito
                      </p>
                    </div>
                  </div>
                  <div class="flex flex-col gap-4">
                    <div class="">
                      <p class="font-normal text-xs text-gray-1 mb-3.5">
                        Itens inclusos
                      </p>
                      <div class="text-gray-1 text-xs font-bold list__options">
                        {!! html_entity_decode($package->descricao) !!}
                      </div>
                    </div>
                    <div>
                      <a href="/{{ $category->id }}/{{ $package->id }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
                        Realizar inscrição
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
