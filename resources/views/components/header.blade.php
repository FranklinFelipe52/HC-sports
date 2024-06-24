<div class="absolute w-full bg-white h-full z-40 flex flex-col sm:px-4 sm:pt-6 sm:pb-8">
  <div class="hidden sm:block">
    <a target="_self" href="{{route('home')}}">
      <img src="{{asset('/images/logo.png')}}" alt="">
    </a>
  </div>

  <hr class="hidden sm:block border-gray-6 my-8">

  <nav class="my-auto">
    <ul class="flex justify-around sm:flex-col sm:gap-5">
      <li class="group @yield('homeClass')">
        <a target="_self" target="_self" href="{{route('dashboard_user')}}" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/home-outline.svg')}}" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="{{asset('/images/svg/home-outline-active.svg')}}" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="sm:hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Dashboard
          </p>
        </a>
      </li>
      <li class="group sm:hidden">
        <a target="_self" href="{{route('profile_user')}}" title="Perfil" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="{{asset('/images/svg/user-circle.svg')}}" class="w-full h-full object-cover group-[.active]:hidden" alt="">
            <img src="{{asset('/images/svg/user-circle-active.svg')}}" class="w-full h-full object-cover hidden group-[.active]:block" alt="">
          </div>
        </a>
      </li>
    </ul>
  </nav>

  <hr class="hidden sm:block border-gray-6 my-4">

  <a target="_self" href="{{route('logout')}}" title="Sair" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
    <div class="w-[24px] h-[24px]">
      <img src="{{asset('/images/svg/logout.svg')}}" class="w-full h-full object-cover" alt="">
    </div>
    <p class="hidden lg:block text-brand-v1 font-normal text-sm font-poppins">
      Sair
    </p>
  </a>


  <div class="group active hidden sm:flex items-end justify-center lg:justify-start grow">
    <a target="_self" href="/profile/update" class="w-full flex justify-center lg:justify-start items-center gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
      <div class="w-[32px] h-[32px] shrink-0">
        <img src="{{asset('/images/svg/user-circle.svg')}}" class="w-full h-full object-cover group-[.active]:hidden" alt="">
        <img src="{{asset('/images/svg/user-circle-active.svg')}}" class="w-full h-full object-cover hidden group-[.active]:block" alt="">
      </div>
      <div class="hidden lg:block">
        <p class="text-gray-1 group-[.active]:text-brand-a1 font-bold font-poppins text-sm">
          <!--<?php echo explode(' ', Session('user')->nome_completo)[0]?>-->
          Editar perfil
        </p>
      </div>
    </a>
  </div>
</div>
