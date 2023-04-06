<div class="absolute w-full bg-white h-full z-40 flex flex-col sm:px-4 sm:pt-6 sm:pb-8">
        <div class="hidden sm:block">
          <a href="/src/pages/admin/dashboard.html">
            <img src="/frontend/dist/images/logo.png" alt="">
          </a>
        </div>

        <hr class="hidden sm:block border-gray-6 my-8">

        <nav class="my-auto">
          <ul class="flex justify-around sm:flex-col sm:gap-5">
            <li class="group active">
              <a href="/dashboard" title="Dashboard" class="flex items-center justify-center lg:justify-normal gap-2 px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition">
                <div class="w-[24px] h-[24px]">
                  <img src="/frontend/dist/images/svg/home-outline.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
                  <img src="/frontend/dist/images/svg/home-outline.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
                </div>
                <p class="sm:hidden lg:block text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
                  Dashboard
                </p>
              </a>
            </li>
            <li class="group sm:hidden">
              <a href="" title="Perfil" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition">
                <div class="w-[24px] h-[24px]">
                  <img src="/frontend/dist/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
                </div>
              </a>
            </li>
          </ul>
        </nav>

        <hr class="hidden sm:block border-gray-6 my-8">

        <a href="/logout" title="Sair" class="hidden sm:flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
          <div class="w-[24px] h-[24px]">
            <img src="/frontend/dist/images/svg/logout.svg" class="w-full h-full object-cover" alt="">
          </div>
          <p class="hidden lg:block text-brand-v1 font-normal text-sm font-poppins">
            Sair
          </p>
        </a>


        <div class="hidden sm:flex items-end justify-center lg:justify-start grow">
          <a href="" class="flex items-center gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
            <div class="w-[32px] h-[32px] shrink-0">
              <img src="/frontend/dist/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
            </div>
            <p class="hidden lg:block text-gray-1 font-medium font-poppins text-base">
              Admin GO
            </p>
          </a>
        </div>
      </div>