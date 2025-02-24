<div id="menu-mobile" class="hidden absolute top-0 bg-white w-screen h-screen z-50 p-6 flex flex-col-reverse">
  <div class="flex justify-between">
    <div class="group @if ($type == 5) active @endif items-end justify-center lg:justify-start">
      <a href="/inscricao/admin/profile" class="w-full flex justify-center lg:justify-start items-center gap-2 lg:px-3 py-2 hover:bg-gray-6 rounded-lg transition px-2">
        <div class="w-[32px] h-[32px] shrink-0">
          <img src="/inscricao/images/svg/user-circle.svg" class="w-full h-full object-cover group-[.active]:hidden" alt="">
          <img src="/inscricao/images/svg/user-circle-active.svg" class="w-full h-full object-cover hidden group-[.active]:block" alt="">
        </div>
        <div class="">
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
      </a>
    </div>
    <button data-button="toggle-menu" data-menuId="menu-mobile" class="flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
      <img src="/inscricao/images/svg/close.svg" alt="Ícone do menu">
    </button>
  </div>
  <div class="flex flex-col gap-4 items-center grow justify-center">
    @if (Session('admin')->rule->id == 1)
      <div class="group @if ($type == 6) active @endif">
        <a href="/inscricao/admin/pagamentos" title="Dashboard" class="w-fit flex items-center justify-center lg:justify-normal gap-2 lg:px-3 py-2 group-[.active]:bg-gray-6 group-hover:bg-gray-6 rounded-lg transition px-2">
          <div class="w-[24px] h-[24px]">
            <img src="/inscricao/images/svg/pagamentos.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
            <img src="/inscricao/images/svg/pagamentos-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
          </div>
          <p class="text-gray-1 group-[.active]:text-brand-a1 text-sm font-poppins">
            Pagamentos
          </p>
        </a>
      </div>
    @endif
    @if (Session('admin')->rule->id == 1)
      <a target="_blank" href="/inscricao/admin/report_registrations" class="w-fit flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition mb-4">
        <div class="w-[24px] h-[24px]">
          <img src="/inscricao/images/svg/excel.svg" class="w-full h-full object-cover" alt="">
        </div>
        <p class="text-gray-1 font-normal text-sm font-poppins">
          Gerar Excel
        </p>
      </a>
    @endif
    {{-- <div class="group @if ($type == 7) active @endif">
      <a href="/inscricao/admin/reports" class="flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition mb-4">
        <div class="w-[24px] h-[24px]">
          <img src="/inscricao/images/svg/excel.svg" class="group-[.active]:hidden w-full h-full object-cover" alt="">
          <img src="/inscricao/images/svg/excel-active.svg" class="hidden group-[.active]:block w-full h-full object-cover" alt="">
        </div>
        <p class="block text-gray-1 font-normal text-sm font-poppins group-[.active]:text-brand-a1">
          Relatórios
        </p>
      </a>
    </div> --}}
    <a href="/inscricao/admin/logout" title="Sair" class="w-fit flex items-center gap-2 px-3 py-2 group-[.active]:bg-gray-6 hover:bg-gray-6 rounded-lg transition">
      <div class="w-[24px] h-[24px]">
        <img src="/inscricao/images/svg/logout.svg" class="w-full h-full object-cover" alt="">
      </div>
      <p class="text-brand-v1 font-normal text-sm font-poppins">
        Sair
      </p>
    </a>
  </div>
</div>
