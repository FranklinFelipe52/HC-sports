@extends('PRF.base')

@section('title', 'Caminhada da Mãe Potiguar')

@section('content')

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <div class="flex justify-between">
          <a href="/">
            <img src="/images/CMP/svg/Logo-MaePotiguar.svg" width="200" alt="">
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

      <img src="/images/CMP/img/Testeira-566.png" class="md:hidden w-full" alt="">
      <img src="/images/CMP/img/Testeira-876.png" class="hidden md:block lg:hidden w-full" alt="">
      <img src="/images/CMP/img/Testeira-1130.png" class="hidden lg:block w-full" alt="">

      <div class="grid grid-cols-1 lg:grid-cols-2 pt-8 gap-6">
        <div class="order-2 lg:order-1">
          <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-1 mb-3">
                A CAMINHADA DA MÃE POTIGUAR É UM EVENTO QUE CELEBRA AS MÃES.
            </h2>

            <div class="space-y-4 text-gray-1 text-sm mb-6">
              <p>
                Participe da Caminhada da Mãe Potiguar e celebre com a gente o mês das mães. Contribua para um futuro mais saudável, apoie a amamentação e o bem-estar de toda a família. Seu engajamento é essencial para tornar esse lindo evento ainda mais alegre e solidário.
              </p>
            </div>

            <h2 class="text-xl font-bold text-gray-1 mb-3">
                BUSCAMOS PROMOVER A SAÚDE DA MULHER E DO BEBÊ.
            </h2>

            <div class="space-y-4 text-gray-1 text-sm mb-6">
              <p>
                A Caminhada da Mãe Potiguar celebra o mês das mães com uma bela manifestação de amor e união. Agendada para o dia 04 de maio, a concentração ocorrerá a partir das 15h, no Centro Administrativo do Estado. O roteiro da Caminhada terá 2km, iniciando no Centro Administrativo do Estado, dando uma volta no Estádio Arena das Dunas e retornando ao ponto inicial. Tudo isso, animado por uma banda potiguar sob um trio elétrico.
              </p>

              <p>
                No palco do evento, a renomada Banda The Fevers comemora 49 anos de sucesso com músicas que embalaram gerações. Será um momento incrível!
              </p>

              <p>
                Este evento inspirador é uma iniciativa do Corpo de Bombeiros Militar do Rio Grande do Norte (CBMRN) e da Secretaria de Saúde do Estado (Sesap) e acontece desde 2012 com o apoio de vários parceiros. Neste ano a expectativa é de reunir 10.000 participantes, arrecadando mais de 10 toneladas de alimentos, em uma demonstração de alegria e solidariedade.
              </p>

              <p>
                Não é apenas uma caminhada, mas um movimento que carrega profundas reflexões sobre a saúde da mulher e do bebê, além de estimular a amamentação e reforçar a vital importância da doação de leite materno, nutrindo a cadeia de apoio que sustenta os bancos de leite do Estado e fortalecendo as bases para uma sociedade mais saudável.
              </p>
            </div>


            <h2 class="text-xl font-bold text-gray-1 mb-3">
                VENHA CELEBRAR O DIA DAS MÃES CONOSCO
            </h2>

            <div class="space-y-4 text-gray-1 text-sm mb-6">
              <p>
                Traga sua família e vamos juntos comemorar o mês das mães!
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
                      <a href="/inscricao/{{ $category->id }}/{{ $package->id }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
                        Realizar Inscrição
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
