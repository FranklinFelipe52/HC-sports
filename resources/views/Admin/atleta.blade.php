@extends('Admin.base')

@section('title', 'Perfil')


@section('content')

@foreach ($atleta->registrations as $registration)
    {{-- modal registration --}}
    <div id="modal{{ $registration->id }}" class="hidden">
      <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
        <div class="bg-white mx-3 overflow-hidden rounded-lg w-full max-w-[500px]">
          {{-- modal registration - header --}}
          <div class="bg-gray-6 p-3 md:pr-6 md:pl-5 md:py-4 flex">
            <div class="grow">
              <p class="text-gray-1 text-lg md:text-xl font-semibold">
                Detalhes da Inscrição
              </p>
            </div>
            <button data-modalId="modal{{ $registration->id }}" data-action="close" class="w-[24px] h-[24px] shrink-0">
              <img src="/images/svg/close.svg" class="w-full h-full object-cover" alt="">
            </button>
          </div>

          {{-- modal registration - body --}}
          <div class="text-gray-1 text-base">
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  CPF
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->user->cpf }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  E-mail
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->user->email }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  Modalidade
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->modalities->nome }}
                </p>
              </div>
            </div>
            <div class="p-3 md:py-4 md:px-6 border-b border-gray-5 last:border-b-0 grid grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-1 text-sm font-semibold">
                  Pagamento
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-gray-2 text-sm font-normal">
                  {{ $registration->type_payment->type }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 4]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Visualização de atleta
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container grid grid-cols-1 md:grid-cols-12 w-full">
          <div class="md:col-span-4 lg:col-span-3">
            <div class="border border-gray-5 p-4 rounded-lg mb-6 sm:space-y-6 flex gap-4 sm:gap-8 md:block">
              <div class="w-[80px] h-[80px] sm:w-[100px] sm:h-[100px] rounded-full md:mx-auto shrink-0">
                <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
              </div>
              <div class="flex flex-col sm:flex-row gap-2 sm:gap-8 flex-wrap md:block md:space-y-6">
                <p class="text-sm text-center text-gray-1 font-semibold mb-1">

                <?php echo $atleta->nome_completo ? explode(' ', $atleta->nome_completo)[0]." ".explode(' ', $atleta->nome_completo)[1] : "-";?>
                </p>
              </div>
            </div>
            {{-- <div>
              <a href="/profile/edit/{{$atleta->id}}" class="flex items-center justify-center  gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
                <img src="/images/svg/pencil.svg" alt="">
                <p class="text-white text-sm font-bold font-poppins">
                  Editar perfil
                </p>
              </a>
            </div> --}}
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Dados do atleta
              </h1>
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      CPF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $atleta->cpf); ?>
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      E-mail
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      {{$atleta->email}}
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Nascimento
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">

                      <?php  echo date("d/m/Y", strtotime($atleta->data_nasc))?>
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Gênero
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if($atleta->sexo == 'M')
                      Masculino
                      @else
                      Feminino
                      @endif
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      UF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      {{ $atleta->address->federativeUnit->name }}
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      Cidade
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      @if ($atleta->address->cidade)
                      {{$atleta->address->cidade}}
                      @else
                          -
                      @endif

                    </p>
                  </div>
                </div>
              </div>

              <h1 class="text-lg text-gray-1 font-poppins font-semibold mb-4">
                Inscrição do atleta
              </h1>
              <div class="pt-4 pb-8 pr-4 overflow-auto grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                @if (count($atleta->registrations) !== 0)
                @foreach ($atleta->registrations as $registration)
                  <!-- inscrição - item do grid -->
                  <div class="space-y-8 p-4 border border-gray-5 rounded-lg">
                    <div class="flex justify-between">
                      <div>
                        <div class="flex items-center gap-4">
                          <p class="text-base font-semibold text-gray-1">
                            {{ $registration->modalities->nome }}
                          </p>
                          <div class="@if ($registration->status_regitration->id == 1) bg-feedback-green-1 @elseif ($registration->status_regitration->id == 3) bg-feedback-fill-purple @endif  py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                            <p class="text-white text-[0.5rem] font-bold">
                              {{ $registration->status_regitration->status }}
                            </p>
                          </div>
                        </div>
                        <p class="text-gray-1 text-xs mt-[2px]">
                          Seccional {{ $registration->user->address->federativeUnit->name }}
                        </p>
                      </div>
                      <div class="w-[38px] h-[38px] rounded-full shrink-0">
                        <img src="/images/svg/modalidades/modalidade-{{ $registration->modalities->id }}.svg" class="w-full h-full object-cover" alt="">
                      </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                      <button data-modalId="modal{{ $registration->id }}" data-action="open" class="text-xs font-semibold text-gray-1 grow p-2 rounded border border-gray-5 hover:ring-2 hover:ring-gray-5 hover:ring-opacity-50 disabled:hover:ring-0 disabled:opacity-50 disabled:cursor-not-allowed transition">
                        Detalhes
                      </button>
                      
                    </div>
                  </div>
                @endforeach
                @else
        <div class="alert alert-info" role="alert">
          Nenhuma inscrição cadastrada
        </div>
      @endif

              </div>

              <div class="flex gap-4 flex-wrap">
                <!--
                <a href="/profile/edit/{{$atleta->id}}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
                  <img src="/images/svg/pencil.svg" alt="">
                  <p class="text-white text-sm font-bold font-poppins">
                    Editar perfil
                  </p>
                </a>
                <a href="/profile/password_reset/{{$atleta->id}}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                  <img src="/images/svg/padlock.svg" alt="">
                  <p class="text-brand-a1 text-sm font-bold font-poppins">
                    Alterar senha
                  </p>
                </a>-->
               <!-- <button data-modalId="modal" data-action="open" class="lg:ml-auto flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
                  <img src="/images/svg/trash.svg" alt="">
                  <p class="text-brand-v1 text-sm font-bold font-poppins">
                    Excluir Conta
                  </p>
                </button>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


