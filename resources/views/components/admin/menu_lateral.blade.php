<div class="absolute w-full bg-white h-full z-40 flex flex-col sm:px-4 sm:pt-6 sm:pb-8">
  <div class="hidden sm:block">
    <a target="_self" href="{{route('dashboard_admin')}}">
      <img src="{{asset('/images/logo.png')}}" alt="">
    </a>
  </div>

  <hr class="hidden sm:block border-gray-6 my-8">

  <nav class="my-auto">
    <ul class="flex justify-around sm:flex-col sm:gap-5">

      <li class="group @if ($type == 1) active @endif">
        <a target="_self" href="{{route('dashboard_admin')}}" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/home-outline.svg')}}" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="{{asset('/images/svg/home-outline-active.svg')}}" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Dashboard
          </p>
        </a>
      </li>

      <li class="group @if ($type == 3) active @endif">
        <a target="_self" href="/admin/modalidades" title="Modalidades" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/star-outline.svg')}}" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="{{asset('/images/svg/star-outline-active.svg')}}" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Modalidades
          </p>
        </a>
      </li>
      <li class="group @if ($type == 4) active @endif">
        <a target="_self" href="{{route('users_admin')}}" title="Atletas" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/users.svg')}}" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="{{asset('/images/svg/users-active.svg')}}" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Atletas
          </p>
        </a>
      </li>
      @if (Session('admin')->rule->id == 1)
        <li class="group @if ($type == 6) active @endif hidden sm:block">
          <a target="_self" href="/admin/pagamentos" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
            <div class="w-[24px] h-[24px]">
              <img src="{{asset('/images/svg/pagamentos.svg')}}" class="group-[.active]:hidden w-full h-full object-cover" alt="">
              <img src="{{asset('/images/svg/pagamentos-active.svg')}}" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
            </div>
            <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
              Pagamentos
            </p>
          </a>
        </li>
      @endif
      <li class="group @if ($type == 2) active @endif">
        <a target="_self" href="/admin/administradores" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/gerentes.svg')}}" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="{{asset('/images/svg/gerentes-active.svg')}}" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Administradores
          </p>
        </a>
      </li>
      @if (Session('admin')->rule->id == 1)
      <li class="group">
        <a target="_self" href="{{route('reports_admin_get')}}" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition mb-4">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/excel.svg')}}" class="w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 font-normal text-sm font-poppins">
            Relatórios
          </p>
        </a>
      </li>
     
    @endif
      <li class="group sm:hidden @if ($type == 5 || $type == 6) active @endif">
        <button data-button="toggle-menu" data-menuId="menu-mobile" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <img src="{{asset('/images/svg/menu.svg')}}" alt="Ícone do menu">
        </button>
      </li>
      
    </ul>
  </nav>

  <hr class="hidden sm:block border-gray-6 my-4">
 
 
  <a target="_self" href="{{route('logout_admin')}}" title="Sair" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
    <div class="w-[24px] h-[24px]">
      <img src="{{asset('/images/svg/logout.svg')}}" class="w-full h-full object-cover" alt="">
    </div>
    <p class="hidden lg:block text-brand-v1 font-normal text-sm font-poppins">
      Sair
    </p>
  </a>

  <div class="group @if ($type == 5) active @endif hidden sm:flex items-end justify-center lg:justify-start grow">
    <a target="_self" href="{{route('profile_admin')}}" class="w-full flex justify-center lg:justify-start items-center gap-2 lg:px-3 py-2 hover:bg-gray-6 rounded-lg transition px-2">
      <div class="w-[32px] h-[32px] shrink-0">
        <img src="{{asset('/images/svg/user-circle.svg')}}" class="w-full h-full object-cover group-[.active]:hidden" alt="">
        <img src="{{asset('/images/svg/user-circle-active.svg')}}" class="w-full h-full object-cover hidden group-[.active]:block" alt="">
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
