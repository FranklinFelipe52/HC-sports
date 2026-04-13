@extends('PRF.base')

@section('title', 'Editar perfil - Circuito Dunas 2026')

@section('content')
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral', ['menuItemActive' => 2])
    </div>

    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <header class="sm:pt-8 pb-6">
          <div class="p-6 sm:hidden border-b border-gray-5">
            <a href="/dashboard">
              <img src="/images/CAERN/logo.png" width="200" alt="" />
            </a>
          </div>
          <div class="container mt-6 sm:mt-0 flex items-center gap-3">
            <a href="/profile" class="text-gray-3 hover:text-gray-1 transition">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">Editar perfil</h1>
          </div>
        </header>

        <div class="container max-w-xl">
          <form method="POST" action="/profile/edit" class="space-y-6">
            @csrf

            {{-- Dados pessoais --}}
            <div class="border border-gray-5 rounded-lg p-5 space-y-4">
              <p class="text-xs font-semibold text-brand-prfA1 uppercase tracking-wide">Dados pessoais</p>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Nome completo</label>
                <input onkeyup="this.value = this.value.toUpperCase();" required type="text" name="nome"
                  value="{{ old('nome', $user->nome_completo) }}"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                @error('nome')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">CPF</label>
                <input disabled type="text"
                  value="{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf) }}"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 bg-gray-6 cursor-not-allowed text-gray-3" />
                <p class="text-gray-3 text-xs mt-1">O CPF não pode ser alterado.</p>
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Data de nascimento</label>
                <input required type="text" name="data_nasc" id="field_data_nasc"
                  value="{{ old('data_nasc', \Carbon\Carbon::parse($user->data_nasc)->format('d/m/Y')) }}"
                  placeholder="DD/MM/AAAA"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                @error('data_nasc')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Gênero</label>
                <div class="relative">
                  <select required name="sexo"
                    class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition">
                    <option value="M" @selected(old('sexo', $user->sexo) == 'M')>Masculino</option>
                    <option value="F" @selected(old('sexo', $user->sexo) == 'F')>Feminino</option>
                  </select>
                  <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                  </div>
                </div>
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">E-mail</label>
                <input required type="email" name="email"
                  value="{{ old('email', $user->email) }}"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Contato</label>
                <input required type="text" name="phone" id="field_phone"
                  value="{{ old('phone', $user->phone) }}"
                  placeholder="(00) 00000-0000"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
              </div>
            </div>

            {{-- Endereço --}}
            <div class="border border-gray-5 rounded-lg p-5 space-y-4">
              <p class="text-xs font-semibold text-brand-prfA1 uppercase tracking-wide">Endereço</p>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">CEP</label>
                <input required type="text" name="cep" id="field_cep"
                  value="{{ old('cep', $user->caern_address?->cep) }}"
                  placeholder="00000-000"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Cidade</label>
                  <input onkeyup="this.value = this.value.toUpperCase();" required type="text" name="cidade" id="field_cidade"
                    value="{{ old('cidade', $user->caern_address?->cidade) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                  @error('cidade')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                  <label class="text-gray-1 font-semibold text-sm inline-block mb-1">UF</label>
                  <div class="relative">
                    <select required name="estado" id="field_estado"
                      class="w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition">
                      <option value="">Selecione</option>
                      @foreach ($federativeUnits as $uf)
                        <option value="{{ $uf->id }}"
                          @selected(old('estado', $user->caern_address?->federative_unit_id) == $uf->id)>
                          {{ $uf->initials }}
                        </option>
                      @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                      <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                    </div>
                  </div>
                  @error('estado')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Bairro</label>
                <input onkeyup="this.value = this.value.toUpperCase();" required type="text" name="bairro" id="field_bairro"
                  value="{{ old('bairro', $user->caern_address?->bairro) }}"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
              </div>

              <div>
                <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Rua</label>
                <input onkeyup="this.value = this.value.toUpperCase();" required type="text" name="rua" id="field_rua"
                  value="{{ old('rua', $user->caern_address?->rua) }}"
                  class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Número</label>
                  <input onkeyup="this.value = this.value.toUpperCase();" required type="text" name="number"
                    value="{{ old('number', $user->caern_address?->number) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                </div>
                <div>
                  <label class="text-gray-1 font-semibold text-sm inline-block mb-1">Complemento <span class="text-xs font-normal">(opcional)</span></label>
                  <input onkeyup="this.value = this.value.toUpperCase();" type="text" name="complemento"
                    value="{{ old('complemento', $user->caern_address?->complemento) }}"
                    class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 transition" />
                </div>
              </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 rounded border-[1.5px] border-brand-prfA1 bg-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 transition">
              <p class="text-white text-sm font-bold font-poppins">Salvar alterações</p>
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    new Cleave('#field_data_nasc', { blocks: [2, 2, 4], delimiters: ['/', '/'], numericOnly: true });
    new Cleave('#field_phone', { blocks: [2, 5, 4], delimiters: [' ', '-'], numericOnly: true });
    new Cleave('#field_cep', { blocks: [5, 3], delimiters: ['-'], numericOnly: true });

    // Auto-preenchimento de endereço via CEP
    document.querySelector('#field_cep').addEventListener('change', function (e) {
      if (e.target.value.length === 9) {
        const clean = e.target.value.replace(/\D/g, '');
        fetch(`https://viacep.com.br/ws/${clean}/json/`)
          .then(r => r.json())
          .then(json => {
            if (!json.erro) {
              const estadoSelect = document.querySelector('#field_estado');
              for (let i = 0; i < estadoSelect.options.length; i++) {
                if (estadoSelect.options[i].text === json.uf) {
                  estadoSelect.value = estadoSelect.options[i].value;
                }
              }
              document.querySelector('#field_cidade').value = json.localidade.toUpperCase();
              document.querySelector('#field_rua').value = json.logradouro.toUpperCase();
              document.querySelector('#field_bairro').value = json.bairro.toUpperCase();
            }
          });
      }
    });

    if ('{{ session('erro') }}') {
      Toastify({ text: '{{ session('erro') }}', duration: 4000, gravity: "top", close: true, position: "right", style: { background: "#FBDBDB", color: "#8E1014", boxShadow: "none" } }).showToast();
    }
  </script>
@endsection
