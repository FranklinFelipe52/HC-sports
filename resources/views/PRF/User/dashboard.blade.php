@extends('PRF.base')

@section('title', 'Dashboard')
@section('homeClass', 'active')

@section('content')
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral', ['menuItemActive' => 1])
    </div>

    <!-- Corpo -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <header class="sm:pt-8 pb-6">
          <div class="p-6 sm:hidden border-b border-gray-5">
            <a href="/dashboard">
              <img src="/images/CAERN/logo.png" width="200" alt="" />
            </a>
          </div>
          <div class="container mt-6 sm:mt-0">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">Minhas inscrições</h1>
          </div>
        </header>

        <div class="container">
          @if (count($registrations) === 0)
            <p class="text-gray-3 text-sm">Você ainda não possui inscrições.</p>
          @else
            <div class="flex flex-col gap-8">
              @foreach ($registrations as $reg)
                <div class="border border-gray-5 rounded-lg overflow-hidden">

                  {{-- Cabeçalho do card --}}
                  <div class="flex flex-wrap items-center justify-between gap-2 px-4 py-3 bg-gray-6 border-b border-gray-5">
                    <div class="flex items-center gap-2">
                      <p class="font-bold text-gray-1 text-base">{{ $reg['categoria'] }}</p>
                      @if ($reg['status_registration']->id == 1)
                        <span class="bg-feedback-green-1 text-white text-xs font-bold py-0.5 px-2 rounded-full">
                          {{ $reg['status_registration']->status }}
                        </span>
                      @elseif ($reg['status_registration']->id == 5)
                        <span class="bg-red-500 text-white text-xs font-bold py-0.5 px-2 rounded-full">
                          {{ $reg['status_registration']->status }}
                        </span>
                      @else
                        <span class="bg-gray-4 text-white text-xs font-bold py-0.5 px-2 rounded-full">
                          {{ $reg['status_registration']->status }}
                        </span>
                      @endif
                    </div>
                    <p class="text-xs text-gray-3">
                      Inscrito em {{ \Carbon\Carbon::parse($reg['created_at'])->format('d/m/Y \à\s H:i') }}
                    </p>
                  </div>

                  <div class="px-4 py-5 space-y-6">

                    {{-- Dados da corrida --}}
                    <div>
                      <p class="text-xs font-semibold text-brand-prfA1 uppercase tracking-wide mb-3">Dados da corrida</p>
                      <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div>
                          <p class="text-xs text-gray-3">Distância</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['categoria'] }}</p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Camiseta</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['size_tshirt'] }}</p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Equipe</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['equipe'] ?: '-' }}</p>
                        </div>
                      </div>
                    </div>

                    <hr class="border-gray-5">

                    {{-- Dados pessoais --}}
                    <div>
                      <p class="text-xs font-semibold text-brand-prfA1 uppercase tracking-wide mb-3">Dados pessoais</p>
                      <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="col-span-2 sm:col-span-3">
                          <p class="text-xs text-gray-3">Nome completo</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['nome'] }}</p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">CPF</p>
                          <p class="text-gray-1 text-sm font-medium">
                            {{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $reg['cpf']) }}
                          </p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Data de nascimento</p>
                          <p class="text-gray-1 text-sm font-medium">
                            {{ \Carbon\Carbon::parse($reg['data_nasc'])->format('d/m/Y') }}
                          </p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Gênero</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['sexo'] == 'M' ? 'Masculino' : 'Feminino' }}</p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Contato</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['phone'] }}</p>
                        </div>
                        <div class="col-span-2">
                          <p class="text-xs text-gray-3">E-mail</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['email'] }}</p>
                        </div>
                      </div>
                    </div>

                    <hr class="border-gray-5">

                    {{-- Endereço --}}
                    <div>
                      <p class="text-xs font-semibold text-brand-prfA1 uppercase tracking-wide mb-3">Endereço</p>
                      <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div>
                          <p class="text-xs text-gray-3">CEP</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['cep'] ?: '-' }}</p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Cidade / UF</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['cidade'] }} / {{ $reg['uf'] }}</p>
                        </div>
                        <div>
                          <p class="text-xs text-gray-3">Bairro</p>
                          <p class="text-gray-1 text-sm font-medium">{{ $reg['bairro'] ?: '-' }}</p>
                        </div>
                        <div class="col-span-2">
                          <p class="text-xs text-gray-3">Rua</p>
                          <p class="text-gray-1 text-sm font-medium">
                            {{ $reg['rua'] }}, {{ $reg['numero'] }}
                            @if($reg['complemento']) — {{ $reg['complemento'] }} @endif
                          </p>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('erro') }}') {
      Toastify({ text: '{{ session('erro') }}', duration: 3000, gravity: "top", close: true, position: "right", style: { background: "#FBDBDB", color: "#8E1014", boxShadow: "none" } }).showToast();
    }
    if ('{{ session('success') }}') {
      Toastify({ text: '{{ session('success') }}', duration: 3000, gravity: "top", close: true, position: "right", style: { background: "#EBFBEE", color: "#279424", boxShadow: "none" } }).showToast();
    }
  </script>
@endsection
