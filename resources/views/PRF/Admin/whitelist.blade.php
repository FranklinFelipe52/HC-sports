@extends('Admin.base')

@section('title', 'Whitelist - Circuito Dunas 2026')

@section('content')

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 6])
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-y-auto">
      <div class="px-6 h-full w-full flex flex-col">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Whitelist de Acesso
          </h1>
          <p class="text-sm text-gray-3 mt-1">Gerencie os CPFs e CNPJs autorizados a realizar inscrições.</p>
        </header>

        <!-- Formulário de cadastro -->
        <div class="mb-6 p-5 bg-gray-6 border border-gray-5 rounded-lg">
          <h2 class="text-sm font-semibold text-gray-1 font-poppins mb-4">Adicionar documento</h2>

          <form method="POST" action="/admin/whitelist" class="flex flex-wrap gap-3 items-end">
            @csrf

            <!-- Campo documento -->
            <div class="flex flex-col gap-1 w-full sm:w-auto sm:flex-1 min-w-[200px]">
              <label for="document" class="text-xs font-semibold text-gray-2">CPF ou CNPJ</label>
              <input
                type="text"
                id="document"
                name="document"
                placeholder="000.000.000-00 ou 00.000.000/0000-00"
                maxlength="18"
                class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg border border-gray-5 focus:border-brand-prfA1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-prfA1 transition"
              >
            </div>

            <!-- Campo limite (só exibido para CNPJ via JS) -->
            <div id="max-reg-field" class="hidden flex-col gap-1 w-full sm:w-auto">
              <label for="max_registrations" class="text-xs font-semibold text-gray-2">Limite de inscrições <span class="font-normal text-gray-3">(deixe em branco para ilimitado)</span></label>
              <input
                type="number"
                id="max_registrations"
                name="max_registrations"
                placeholder="Ex: 10"
                min="1"
                class="text-sm text-gray-1 placeholder:text-gray-3 p-2 rounded-lg border border-gray-5 focus:border-brand-prfA1 focus:outline-1 focus:outline-offset-0 focus:outline-brand-prfA1 transition w-40"
              >
            </div>

            <button
              type="submit"
              class="bg-brand-prfA1 text-white text-sm font-semibold px-5 py-2 rounded-lg hover:opacity-90 transition h-[38px]"
            >
              Adicionar
            </button>
          </form>
        </div>

        <!-- Tabela -->
        <div class="h-fit flex flex-col overflow-hidden mb-8">

          <!-- Cabeçalho da tabela -->
          <div class="border border-gray-5 rounded-t-lg">
            <div role="row" class="grid grid-cols-12 px-4 py-3 bg-gray-6">
              <div role="columnheader" class="text-start col-span-4">
                <p class="text-sm font-semibold text-gray-1">Documento</p>
              </div>
              <div role="columnheader" class="text-start col-span-2">
                <p class="text-sm font-semibold text-gray-1">Tipo</p>
              </div>
              <div role="columnheader" class="text-start col-span-2">
                <p class="text-sm font-semibold text-gray-1">Limite</p>
              </div>
              <div role="columnheader" class="text-start col-span-2">
                <p class="text-sm font-semibold text-gray-1">Usadas</p>
              </div>
              <div role="columnheader" class="col-span-2 text-end">
                <p class="text-sm font-semibold text-gray-1">Ações</p>
              </div>
            </div>
          </div>

          <!-- Corpo da tabela -->
          <div class="overflow-y-auto border border-t-0 border-gray-5 rounded-b-lg">
            @if ($entries->count() > 0)
              @foreach ($entries as $entry)
                @php
                  $usedCount = $entry->registrationCount();
                  $isCnpj = $entry->type === 'cnpj';
                  $limitText = $isCnpj
                    ? ($entry->max_registrations ? $entry->max_registrations : 'Ilimitado')
                    : '—';
                  $usedText = $isCnpj ? $usedCount : '—';

                  // Formata o documento
                  if ($isCnpj) {
                    $formatted = preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $entry->document);
                  } else {
                    $formatted = preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $entry->document);
                  }

                  // Badge de uso para CNPJ
                  $usageColor = 'text-gray-2';
                  if ($isCnpj && $entry->max_registrations) {
                    if ($usedCount >= $entry->max_registrations) {
                      $usageColor = 'text-feedback-error font-semibold';
                    } elseif ($usedCount >= $entry->max_registrations * 0.8) {
                      $usageColor = 'text-yellow-600 font-semibold';
                    }
                  }
                @endphp

                <div role="row" class="px-4 grid grid-cols-12 border-b border-b-gray-5 last:border-b-0 items-center">
                  <div role="cell" class="py-3 col-span-4">
                    <p class="text-sm text-gray-1 font-mono">{{ $formatted }}</p>
                  </div>

                  <div role="cell" class="py-3 col-span-2">
                    @if ($isCnpj)
                      <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">CNPJ</span>
                    @else
                      <span class="text-xs font-semibold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">CPF</span>
                    @endif
                  </div>

                  <div role="cell" class="py-3 col-span-2">
                    <p class="text-sm text-gray-2">{{ $limitText }}</p>
                  </div>

                  <div role="cell" class="py-3 col-span-2">
                    @if ($isCnpj)
                      <p class="text-sm {{ $usageColor }}">
                        {{ $usedCount }}
                        @if ($entry->max_registrations)
                          / {{ $entry->max_registrations }}
                        @endif
                      </p>
                    @else
                      <p class="text-sm {{ $usedCount > 0 ? 'text-green-700 font-semibold' : 'text-gray-3' }}">
                        {{ $usedCount > 0 ? 'Sim ('.$usedCount.')' : 'Não' }}
                      </p>
                    @endif
                  </div>

                  @if ($usedCount === 0)
                  <div role="cell" class="py-3 col-span-2 flex justify-end">
                    <form method="POST" action="/admin/whitelist/{{ $entry->id }}" onsubmit="return confirm('Remover {{ $formatted }} da whitelist?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-xs text-feedback-error hover:underline font-semibold">
                        Remover
                      </button>
                    </form>
                  </div>
                  @else
                  <div role="cell" class="py-3 col-span-2"></div>
                  @endif
                </div>
              @endforeach
            @else
              <div class="bg-feedback-fill-blue p-4">
                <p class="text-brand-prfA1 text-sm">Nenhum documento cadastrado na whitelist.</p>
              </div>
            @endif
          </div>
        </div>

        <!-- Resumo -->
        @if ($entries->count() > 0)
          @php
            $totalCpf  = $entries->where('type', 'cpf')->count();
            $totalCnpj = $entries->where('type', 'cnpj')->count();
          @endphp
          <div class="pb-8 flex gap-6 text-sm text-gray-3">
            <span>{{ $entries->count() }} documento(s) no total</span>
            <span>{{ $totalCpf }} CPF(s)</span>
            <span>{{ $totalCnpj }} CNPJ(s)</span>
          </div>
        @endif

      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('erro') }}') {
      showErrorToastfy('{{ session('erro') }}');
    }

    if ('{{ session('success') }}') {
      showSuccessToastfy('{{ session('success') }}');
    }

    function showSuccessToastfy(text) {
      Toastify({
        text: text,
        duration: 3000,
        gravity: "top",
        close: true,
        position: "right",
        style: { background: "#EBFBEE", color: "#279424", boxShadow: "none" },
      }).showToast();
    }

    function showErrorToastfy(text) {
      Toastify({
        text: text,
        duration: 3000,
        gravity: "top",
        close: true,
        position: "right",
        style: { background: "#FBDBDB", color: "#8E1014", boxShadow: "none" },
      }).showToast();
    }

    // Mostra/oculta campo de limite conforme o documento digitado é CPF ou CNPJ
    const docInput   = document.getElementById('document');
    const maxRegField = document.getElementById('max-reg-field');

    docInput.addEventListener('input', function () {
      const digits = this.value.replace(/\D/g, '');
      if (digits.length > 11) {
        maxRegField.classList.remove('hidden');
        maxRegField.classList.add('flex');
      } else {
        maxRegField.classList.add('hidden');
        maxRegField.classList.remove('flex');
        document.getElementById('max_registrations').value = '';
      }

      // Formata automaticamente enquanto digita
      if (digits.length <= 11) {
        // CPF: 000.000.000-00
        let v = digits;
        v = v.replace(/^(\d{3})(\d)/, '$1.$2');
        v = v.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        v = v.replace(/\.(\d{3})(\d)/, '.$1-$2');
        this.value = v;
      } else {
        // CNPJ: 00.000.000/0000-00
        let v = digits.slice(0, 14);
        v = v.replace(/^(\d{2})(\d)/, '$1.$2');
        v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
        v = v.replace(/(\d{4})(\d)/, '$1-$2');
        this.value = v;
      }
    });
  </script>

@endsection
