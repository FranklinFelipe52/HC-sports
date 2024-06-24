@extends('PRF.base')

@section('title', 'Home')

@section('content')

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <div class="flex justify-between">
          <a target="_self" href="{{route('home')}}">
            <img src="{{asset('/images/logo-hc.png')}}" alt="">
          </a>
          <div class="flex gap-4">
            <div class="flex items-center justify-center">
              <a target="_self" href="{{route('login_get')}}" style="text-align: center;" class="font-semibold border border-brand-prfA1 rounded-md px-3.5 py-2 text-brand-prfA1 hover:text-white hover:bg-brand-prfA1 transition-all">
                Acesse seu cadastro
              </a>
            </div>
            
          </div>
        </div>
      </div>
    </header>

    <main class="container grow pt-6 pb-32">
      <img src="{{asset('/images/PRF/colabore-sm.png')}}" class="md:hidden w-full" alt="">
      <img src="{{asset('/images/PRF/colabore-md.png')}}" class="hidden md:block lg:hidden w-full" alt="">
      <img src="{{asset('/images/PRF/colabore-lg.png')}}" class="hidden lg:block w-full" alt="">

      <div class="grid grid-cols-1 lg:grid-cols-2 pt-8 gap-6">
        <div class="order-2 lg:order-1">
          <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-1 mb-6">
              A Corrida
            </h2>
            

            <div class="space-y-4 text-gray-1 text-sm">
              <p>
                A Meia Maratona PRF é parte da iniciativa POLICIAIS CONTRA O CÂNCER INFANTIL, uma campanha nacional que apoia entidades que cuidam de crianças com câncer.
              </p>

              <p>
                Em todas as edições anteriores, o lucro da prova foi destinado a instituições do Rio Grande do Norte. Em 2023, foram doados 27 mil reais ao GACC-RN (Grupo de Apoio à Criança com Câncer do Rio Grande do Norte). Para 2024, a meta é superar essa marca. O evento está agendado para o dia 10 de novembro de 2024, com largada às 5h30, na Arena das Dunas, em Natal. Os participantes podem escolher entre percursos de 21Km, 10Km e 5Km.
              </p>
              <p>
                Além da oportunidade de correr ao longo da BR-101, na capital potiguar, os participantes contribuem para a campanha Policiais Contra o Câncer Infantil, onde parte do valor da inscrição é revertido para uma instituição filantrópica que atende crianças com câncer.
              </p>
            </div>
          </div>

          <div>
            <h3 class="text-base font-bold text-gray-1 mb-6">
              Fotos
            </h3>

            <div class="grid grid-rows-1 grid-cols-2 md:grid-cols-4 gap-4">
              <div class="row-span-1 col-span-1 rounded-md overflow-hidden">
                <img src="{{asset('/images/PRF/foto-3.png')}}" class="w-full h-full object-cover" alt="">
              </div>
              <div class="row-span-1 col-span-1 rounded-md overflow-hidden">
                <img src="{{asset('/images/PRF/foto-4.jpg')}}" class="w-full h-full object-cover" alt="">
              </div>
              <div class="md:row-span-2 md:col-span-2 rounded-md overflow-hidden">
                <img src="{{asset('/images/PRF/foto-2.jpg')}}" class="w-full h-full object-cover" alt="">
              </div>
              <div class="row-span-1 md:col-span-2 rounded-md overflow-hidden">
                <img src="{{asset('/images/PRF/foto-1.jpg')}}" class="w-full h-full object-cover" alt="">
              </div>
            </div>
          </div>
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
                        {{ $category->nome }} {{ $package->nome }}
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
                        <a target="_self" target="_self" href="{{route('inscricao_register_get', ['category_id' => $category->id, 'package_id' => $package->id ])}}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
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


    <!-- Seção de Patrocinadores, Realizadores e organizadores -->
    <section class="py-24 bg-fill-1">
      <div class="container px-24 px-sm-0 flex justify-center flex-wrap gap-8">
        <div class="">
          <h2 class="text-dark-1 mb-4 text-lg font-normal font-poppins text-center">
            Ação social
          </h2>

          <div class="flex gap-8 flex-wrap justify-center">
            <div class="marca">
              <img src="{{asset('/images/PRF/marcas/acao-social.png')}}" alt="">
            </div>
          </div>
        </div>
        <div class="">
          <h2 class="text-dark-1 mb-4 text-lg font-normal font-poppins text-center">
            Organização
          </h2>

          <div class="flex gap-8 flex-wrap justify-center">
            <a  href="https://www.hcsports.com.br/" class="marca" target="_blank">
              <img src="{{asset('/images/PRF/marcas/hc.png')}}" alt="">
            </a>
          </div>
        </div>
        <div class="">
          <h2 class="text-dark-1 mb-4 text-lg fw-medium font-poppins text-center">
            Realização
          </h2>

          <div class="flex gap-4 flex-wrap justify-center">
            <a  href="https://fenaprf.org.br/novo/" class="marca" target="_blank">
              <img src="{{asset('/images/PRF/marcas/FenaPRF.png')}}" alt="">
            </a>

            <a  href="https://www.gov.br/prf/pt-br" class="marca" target="_blank">
              <img src="{{asset('/images/PRF/marcas/prf.png')}}" alt="">
            </a>

            <a  href="https://sinprfrn.org.br/" class="marca" target="_blank">
              <img src="{{asset('/images/PRF/marcas/SindPRF-RN.png')}}" alt="">
            </a>
          </div>
        </div>
      </div>
    </section>

    @include('PRF.Components.footer')
  </div>
@endsection
