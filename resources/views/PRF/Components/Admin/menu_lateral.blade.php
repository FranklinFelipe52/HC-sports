<div class="absolute w-full bg-white h-full z-40 flex flex-col sm:px-4 sm:pt-6 sm:pb-8">
  <div class="hidden sm:block">
    <a href="/dashboard" class="block overflow-hidden rounded-lg">
      <img src="/images/PRF/Logo-Meia-PRF.png" class="lg-h-[100px]" alt="">
    </a>
  </div>

  <hr class="hidden sm:block border-gray-6 my-8">

  <nav class="my-auto">
    <ul class="flex justify-around sm:flex-col sm:gap-5">
      <li class="group @if ($menuItemActive == 1) active @endif">
        <a href="/admin/dashboard" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/home-outline.svg" class="w-full h-full object-cover" alt="">
          </div>
          <p class="sm:hidden lg:block text-gray-1 group-[.active]:text-brand-prfA1 text-sm font-poppins">
            Dashboard
          </p>
        </a>
      </li>

      <li class="group @if ($menuItemActive == 2) active @endif">
        <a href="/admin/users" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/users.svg" class="w-full h-full object-cover" alt="">
          </div>
          <p class="sm:hidden lg:block text-gray-1 group-[.active]:text-brand-prfA1 text-sm font-poppins">
            Atletas
          </p>
        </a>
      </li>

      <li class="group @if ($menuItemActive == 3) active @endif">
        <a href="/admin/reports" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition mb-4">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/excel.svg" class="w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-gray-1 font-normal text-sm font-poppins">
            Relatórios
          </p>
        </a>
      </li>

      <li class="group sm:hidden">
        <div title="Perfil" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
          </div>
        </div>
      </li>
      <li class="group sm:hidden">
        <a href="/admin/logout" title="Sair" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/images/svg/logout.svg" class="w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-brand-v1 font-normal text-sm font-poppins">
            Sair
          </p>
        </a>
      </li>
    </ul>
  </nav>

  <hr class="hidden sm:block border-gray-6 my-4">

  <a href="/admin/logout" title="Sair" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
    <div class="w-[24px] h-[24px]">
      <img src="/images/svg/logout.svg" class="w-full h-full object-cover" alt="">
    </div>
    <p class="hidden lg:block text-brand-v1 font-normal text-sm font-poppins">
      Sair
    </p>
  </a>


  <div class="group hidden sm:flex items-end justify-center lg:justify-start grow">
    <a class="w-full flex justify-center lg:justify-start items-center gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
      <div class="w-[32px] h-[32px] shrink-0">
        <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover group-[.active]:hidden" alt="">
        <img src="/images/svg/user-circle-active.svg" class="w-full h-full object-cover hidden group-[.active]:block" alt="">
      </div>
      <div class="hidden lg:block">
        <p class="text-gray-1 group-[.active]:text-brand-prfA1 font-bold font-poppins text-sm">
          <?php echo explode(' ', Session('admin')->nome_completo)[0]; ?>
        </p>
      </div>
    </a>
  </div>
</div>
