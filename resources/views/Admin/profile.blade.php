@extends('Admin.base')

@section('title', 'Perfil')

@section('content')
  <!-- modal -->
  <div id="modal"  class="hidden">
    <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
      <div class="bg-white mx-3 overflow-hidden rounded-lg w-full max-w-[500px]">
        <!-- modal header -->
        <div class="bg-white p-3 md:pr-6 md:pl-5 md:py-4 flex">
          <div class="grow">
            <p class="text-gray-1 text-lg md:text-xl font-semibold">
              Personificação de administrador
            </p>
          </div>
          <button data-modalId="modal" data-action="close" class="w-[24px] h-[24px] shrink-0">
            <img src="/images/svg/close.svg" class="w-full h-full object-cover" alt="">
          </button>
        </div>
        <!-- modal body -->
        <div class="text-gray-1 text-base p-3 md:pr-6 md:pl-5 pt-0">
          <hr class="border-gray-5 mb-4">
          <form action="/admin/personification/update" method="post">
            @csrf
            <p class="text-gray-2 text-sm mb-6">
              Selecione um estado para personificar o administrador da caixa de assistência.
            </p>
            <div>
              <label class="text-gray-1 font-semibold text-sm inline-block mb-2" for="select_exemplo">
                Selecione a UF
              </label>
              <div class="relative">
                <select required class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-500 appearance-none transition" name="uf" id="select_exemplo">
                <option value disabled selected>UF</option>
                  @foreach ($federative_units as $federative_unit)
                    <option {{ Request::get('uf') && Request::get('uf') == $federative_unit->id ? 'selected' : '' }} value="{{ $federative_unit->id }}">{{ $federative_unit->initials }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/svg/chevron-down.svg" alt="" />
                </div>
              </div>
              <button type="submit" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition mt-4 ml-auto mb-4">
                <p class="text-white text-sm font-bold font-poppins">
                  Personificar
                </p>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type' => 5]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
    @if(Session('admin')->personification)
    @include('components.admin.personification_nav')
    @endif
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Perfil
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

                  <?php echo explode(' ', Session('admin')->nome_completo)[0] . ' ' . explode(' ', Session('admin')->nome_completo)[1]; ?>
                </p>
              </div>
            </div>
            @if (Session('admin')->rule->id == 1)
            <div class="flex gap-4 flex-wrap">
              <button data-modalId="modal" data-action="open" class="flex items-center justify-center gap-2 w-full px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
                <img src="/images/svg/key-active.svg" alt="">
                <p class="text-brand-a1 text-sm font-bold font-poppins">
                  Personificar
                </p>
              </button>
            </div>
            @endif
          </div>
          <div class="md:col-span-8 flex flex-col overflow-hidden md:pl-8 p-1 pt-0">
            <div class="w-full">
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-1 font-semibold">
                      CPF
                    </p>
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <p class="text-sm text-gray-2 font-normal">
                      <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', Session('admin')->cpf); ?>
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
                      {{ Session('admin')->email }}
                    </p>
                  </div>
                </div>
              </div>
              <div class="flex gap-4 flex-wrap">
                <!--
                        <a href="/profile/edit/{{ Session('admin')->id }}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 bg-brand-a1 hover:ring-brand-a1 hover:ring-opacity-50 transition">
                          <img src="/images/svg/pencil.svg" alt="">
                          <p class="text-white text-sm font-bold font-poppins">
                            Editar perfil
                          </p>
                        </a>
                        <a href="/profile/password_reset/{{ Session('admin')->id }}" class="flex items-center justify-center sm:justify-start gap-2 w-full sm:w-fit px-3 py-2 rounded-md border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-white transition">
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
