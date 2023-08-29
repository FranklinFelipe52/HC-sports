<div class="absolute w-full bg-white h-full z-40 flex flex-col sm:px-4 sm:pt-6 sm:pb-8">
  <div class="hidden sm:block">
    <a href="/admin/dashboard">
      <img src="/images/logo.png" alt="">
    </a>
  </div>

  <hr class="hidden sm:block border-gray-6 my-8">

  <nav class="my-auto">
    <ul class="flex justify-around sm:flex-col sm:gap-5">

      <li class="group @if ($type == 1) active @endif">
        <a href="/admin/dashboard" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/home-outline.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="/images/svg/home-outline-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Dashboard
          </p>
        </a>
      </li>

      <li class="group @if ($type == 3) active @endif">
        <a href="/admin/modalidades" title="Modalidades" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/star-outline.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="/images/svg/star-outline-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Modalidades
          </p>
        </a>
      </li>
      <li class="group @if ($type == 4) active @endif">
        <a href="/admin/users" title="Atletas" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/users.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="/images/svg/users-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Atletas
          </p>
        </a>
      </li>
      @if (Session('admin')->rule->id == 1)
        <li class="group @if ($type == 6) active @endif hidden sm:block">
          <a href="/admin/pagamentos" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
            <div class="w-[24px] h-[24px]">
              <img src="/images/svg/pagamentos.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
              <img src="/images/svg/pagamentos-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
            </div>
            <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
              Pagamentos
            </p>
          </a>
        </li>
      @endif
      <li class="group @if ($type == 2) active @endif">
        <a href="/admin/administradores" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/gerentes.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="/images/svg/gerentes-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Administradores
          </p>
        </a>
      </li>
      @if (Session('admin')->rule->id == 1)
      <li class="group">
        <a href="/admin/reports" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition mb-4">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/excel.svg" class="w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 font-normal text-sm font-poppins">
            Relatórios
          </p>
        </a>
      </li>

    @endif
      <li class="group sm:hidden @if ($type == 5 || $type == 6) active @endif">
        <button data-button="toggle-menu" data-menuId="menu-mobile" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <img src="/images/svg/menu.svg" alt="Ícone do menu">
        </button>
      </li>

    </ul>
  </nav>

  <hr class="hidden sm:block border-gray-6 my-4">

  {{-- <div class="group @if ($type == 7) active @endif">
    <a href="/admin/reports" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition mb-4">
      <div class="w-[24px] h-[24px]">
        <img src="/images/svg/excel.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
        <img src="/images/svg/excel-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
      </div>
      <p class="hidden lg:block text-gray-1 font-normal text-sm font-poppins group-[.active]:text-brand-a1">
        Relatórios
      </p>
    </a>
  </div> --}}
  <a href="/admin/logout" title="Sair" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
    <div class="w-[24px] h-[24px]">
      <img src="/images/svg/logout.svg" class="w-full h-full object-cover" alt="">
    </div>
    <p class="hidden lg:block text-brand-v1 font-normal text-sm font-poppins">
      Sair
    </p>
  </a>

  <div class="group @if ($type == 5) active @endif hidden sm:flex items-end justify-center lg:justify-start grow">
    <a href="/admin/profile" class="w-full flex justify-center lg:justify-start items-center gap-2 lg:px-3 py-2 hover:bg-gray-6 rounded-lg transition px-2">
      <div class="w-[32px] h-[32px] shrink-0">
        <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover group-[.active]:hidden" alt="">
        <img src="/images/svg/user-circle-active.svg" class="w-full h-full object-cover hidden group-[.active]:block" alt="">
      </div>
      <div class="hidden lg:block">
        <p class="text-gray-1 group-[.active]:text-brand-a1 font-bold font-poppins text-sm">
          {{ explode(' ', Session('admin')->nome_completo)[0] }}
        </p>
        <p class="text-gray-2 group-[.active]:text-brand-a1 font-medium font-poppins text-xs">
          @if (Session('admin')->rule->id == 1)
            Administrador Geral
          @else
            Administrador {{ Session('admin')->federativeUnit->initials }}
          @endif
        </p>
      </div>
      <div>
      </div>
    </a>
  </div>
</div>
