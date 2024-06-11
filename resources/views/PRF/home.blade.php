@extends('PRF.base')

@section('title', 'Home')

@section('content')

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <div class="flex justify-between">
          <a href="/">
            <img src="/images/logo-hc.png" alt="">
          </a>
          <div class="flex gap-4">
            <div class="flex items-center justify-center">
              <a href="/login" style="text-align: center;" class="font-semibold border border-brand-prfA1 rounded-md px-3.5 py-2 text-brand-prfA1 hover:text-white hover:bg-brand-prfA1 transition-all">
                Acesse seu cadastro
              </a>
            </div>
            {{-- <div class="relative w-full max-w-[200px]">
              <button class="btn btn-secondary dropdown-toggle ms-auto flex gap-4 items-center hover:bg-gray-6 transition-all rounded-full p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/images/svg/user-circle.svg" alt="" class="rounded-full w-8 h-8 object-cover">
              </button>
              <ul class="dropdown-menu absolute right-0 shadow-sm w-full mt-2 bg-white rounded-lg border py-2">
                <li>
                  <a href="/login" class="inline-flex gap-2 py-2 px-3.5 w-full hover:bg-gray-6 transition-all">
                    <span class="text-gray-1 font-medium ">
                      Faça Login
                    </span>
                  </a>
                </li>
                <li>
                  <a href="https://www.meiamaratonaprf191.com.br/" target="_blank" class="inline-flex gap-2 py-2 px-3.5 w-full hover:bg-gray-6 transition-all">
                    <span class="text-gray-1 font-medium ">
                      Veja nosso site
                    </span>
                  </a>
                </li>
              </ul>
            </div> --}}
          </div>
        </div>
      </div>
    </header>

    <main class="container grow pt-6 pb-32">
      <img src="/images/PRF/colabore-sm.png" class="md:hidden w-full" alt="">
      <img src="/images/PRF/colabore-md.png" class="hidden md:block lg:hidden w-full" alt="">
      <img src="/images/PRF/colabore-lg.png" class="hidden lg:block w-full" alt="">

      <div class="grid grid-cols-1 lg:grid-cols-2 pt-8 gap-6">
        <div class="order-2 lg:order-1">
          <div class="mb-12">
            <h2 class="text-xl font-bold text-gray-1 mb-6">
              A Corrida
            </h2>

            <div class="space-y-4 text-gray-1 text-sm">
              <p>
                Com provas de 21Km, 10Km e 5Km, a MEIA MARATONA PRF 191 é uma oportunidade única de colocar nas ruas um evento representativo e de grande repercussão na sociedade, aproximando o público da entidade e com a possibilidade de realização de diversas ações educativas e sociais.
              </p>

              <p>
                É a única prova no Rio Grande do Norte que possibilita o atleta a usar a BR para correr com total segurança, o que valoriza ainda mais a participação dos atletas, que buscam sempre provas com diferenciais importantes na realização.
              </p>
            </div>
          </div>

          <div>
            <h3 class="text-base font-bold text-gray-1 mb-6">
              Fotos
            </h3>

            <div class="grid grid-rows-1 grid-cols-2 md:grid-cols-4 gap-4">
              <div class="row-span-1 col-span-1 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-3.png" class="w-full h-full object-cover" alt="">
              </div>
              <div class="row-span-1 col-span-1 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-4.jpg" class="w-full h-full object-cover" alt="">
              </div>
              <div class="md:row-span-2 md:col-span-2 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-2.JPG" class="w-full h-full object-cover" alt="">
              </div>
              <div class="row-span-1 md:col-span-2 rounded-md overflow-hidden">
                <img src="/images/PRF/foto-1.jpg" class="w-full h-full object-cover" alt="">
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


    <!-- Seção de Patrocinadores, Realizadores e organizadores -->
    <section class="py-24 bg-fill-1">
      <div class="container px-24 px-sm-0 flex justify-center flex-wrap gap-8">
        <div class="">
          <h2 class="text-dark-1 mb-4 text-lg font-normal font-poppins text-center">
            Ação social
          </h2>

          <div class="flex gap-8 flex-wrap justify-center">
            <div class="marca">
              <img src="/images/PRF/marcas/acao-social.png" alt="">
            </div>
          </div>
        </div>
        <div class="">
          <h2 class="text-dark-1 mb-4 text-lg font-normal font-poppins text-center">
            Organização
          </h2>

          <div class="flex gap-8 flex-wrap justify-center">
            <a href="https://www.hcsports.com.br/" class="marca" target="_blank">
              <img src="/images/PRF/marcas/hc.png" alt="">
            </a>
          </div>
        </div>
        <div class="">
          <h2 class="text-dark-1 mb-4 text-lg fw-medium font-poppins text-center">
            Realização
          </h2>

          <div class="flex gap-4 flex-wrap justify-center">
            <a href="https://fenaprf.org.br/novo/" class="marca" target="_blank">
              <img src="/images/PRF/marcas/FenaPRF.png" alt="">
            </a>

            <a href="https://www.gov.br/prf/pt-br" class="marca" target="_blank">
              <img src="/images/PRF/marcas/prf.png" alt="">
            </a>

            <a href="https://sinprfrn.org.br/" class="marca" target="_blank">
              <img src="/images/PRF/marcas/SindPRF-RN.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </section>

    @include('PRF.Components.footer')
  </div>
@endsection
