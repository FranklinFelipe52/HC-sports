@extends('PRF.base')

@section('title', 'Complete sua inscrição - Meia Maratona PRF')

@section('content')
  <div class="lg:grid lg:grid-cols-7 xl:container">
    <div class="lg:sticky lg:top-0 lg:h-screen max-h-[1200px] lg:col-span-3 bg-white bg-[url('/images/background.png')] bg-cover bg-no-repeat">
      <div class="flex flex-col h-full">
        <header class="p-5">
          <a href="/">
            <img src="/images/PRF/Logo-Meia-PRF.png" class="h-[100px]"  alt="" />
          </a>
        </header>
        <div class="p-8 pb-12 lg:p-8 my-auto">
          <div class="w-fit">
            <h1 class="text-4xl md:text-5xl font-semibold text-brand-prfA1 font-poppins">
              Inscrição
            </h1>
            <div class="bg-brand-prfA1 h-1 rounded-lg mt-3.5 mb-2 w-1/2"></div>
          </div>
          <p class="text-sm font-normal text-gray-1">
            Preencha o formulário para completar sua inscrição.
          </p>
        </div>
        <div class="hidden lg:block p-8"></div>
        <div class="mx-auto pb-8 lg:p-0 lg:absolute lg:top-1/2 lg:-right-6">
          <a href="#cadastro_formulario" class="bg-dark-400 w-12 h-12 flex justify-center items-center rounded-full rotate-90 lg:rotate-0">
            <img src="/images/svg/chevron-left-fill.svg" alt="" />
          </a>
        </div>
      </div>
    </div>
    <div class="bg-white h-full lg:col-span-4 px-8 py-20">
      <div class="mx-auto w-full max-w-[327px]">
        <form method="post" id="cadastro_formulario">
          @csrf
          <h2 class="text-gray-1 text-xl font-semibold font-poppins">
            Dados pessoais
          </h2>
          <hr class="mt-4 mb-6 border-gray-4" />
          <div class="space-y-4 mb-20">
            <div>
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_cpf_field">
                CPF
              </label>
              <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cadastro_cpf_field" name="cpf" placeholder="Digite o seu CPF" value="{{ old('cpf') }}" />
            </div>
            <div>
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_nome_completo_field">
                Nome completo
              </label>
              <input onkeyup="this.value = this.value.toUpperCase();" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="cadastro_nome_completo_field" name="nome" value="{{ old('nome') }}" placeholder="Digite o seu nome completo" />

            </div>
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_nascimento_field">
                Nascimento
              </label>
              <div class="relative">
                <input required class="w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="date" id="cadastro_date_field" name="data_nasc" value="{{ old('data_nasc') }}" placeholder="DD/MM/AAAA" />
                <div class="pointer-events-none absolute top-4 right-4 bg-white pl-4">
                  <img src="/images/PRF/svg/calendar.svg" alt="" />
                </div>
              </div>
              @error('data_nasc')
                <p class="text-red-600">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_genero_field">
                Gênero
              </label>
              <div class="relative">
                <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="sexo" id="cadastro_genero_field">
                  <option @if (old('sexo') == 'M') @selected(true) @endif value="M">
                    Masculino</option>
                  <option @if (old('sexo') == 'F') @selected(true) @endif value="F">Feminino
                  </option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>

            <div class="mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_package_field">
                Possui deficiência física comprovada?
              </label>

              <div class="relative">
                <select data-item="select" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="pcd" id="inscricao_pcd_field">
                  <option value="N" selected>Não</option>
                  @foreach ($deficiencys as $deficiency)
                    <option @if (old('pcd') == $deficiency->id) @selected(true) @endif value={{ $deficiency->id }}>{{ $deficiency->nome }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>
          </div>
          <h2 class="text-gray-1 text-xl font-semibold font-poppins">
            Dados da Corrida
          </h2>
          <hr class="mt-4 mb-6 border-gray-4" />
          <div class="space-y-4 mb-20">
            <div>
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_text_exemplo">
                Distância
              </label>
              <input disabled class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" value="{{ $category->nome }}" />
            </div>
            <div>
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_text_exemplo">
                Equipe
              </label>
              <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="input_text_exemplo" name="equipe" value="{{ old('equipe') }}" placeholder="Digite o nome da sua equipe" />
              @error('equipe')
                <p class="text-red-600">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-6">
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_size_tshirt_field">
                Camiseta
              </label>
              <div class="relative">
                <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="size_tshirt" id="inscricao_size_tshirt_field">
                  <option selected value>Selecione</option>
                  @foreach ($size_tshirts as $size_tshirt)
                    <option @if (old('size_tshirt') == $size_tshirt->id) @selected(true) @endif value={{ $size_tshirt->id }}>{{ $size_tshirt->nome }}</option>
                  @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                  <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                </div>
              </div>
            </div>
          </div>
          <h2 class="text-gray-1 text-xl font-semibold font-poppins">
            Ajude a campanha beneficente
          </h2>
          <hr class="mt-4 mb-6 border-gray-4" />
          <div class="space-y-4 mb-20">
            <div class="space-y-4">
              @foreach ($tshirts as $tshirt)
                <div class="border rounded border-gray-5 p-2">
                  <div>
                    <a href="/images/PRF/Camiseta-PRF-2023.png" target="_blank">
                      <img src="/images/PRF/Camiseta-PRF-2023.png" class="h-[100px] w-[100px]" alt="">
                    </a>
                  </div>
                  <div class="py-4 flex gap-4">
                    <div class="flex items-center">
                      <input class="prf-checkbox" type="checkbox" name="tshirts[]" value="{{ $tshirt->id }}" id="flexCheckDefault" />
                    </div>
                    <div class="flex flex-col gap-4">
                      <div class="">
                        <p class="text-gray-1 text-sm">
                          {{ $tshirt->nome }}
                        </p>
                        <p class="text-dark-1 text-sm font-bold mb-2">
                          R$ {{ number_format($tshirt->price, 2, ',', '.') }}
                        </p>
                        <p class="text-gray-1 text-xs">
                          <span class="text-gray-8">Itens inclusos:</span> {{ $tshirt->descricao }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <h2 class="text-gray-1 text-xl font-semibold font-poppins">
            Dados de login
          </h2>
          <hr class="mt-4 mb-6 border-gray-4" />
          <div class="space-y-4 mb-20">
            <div>
              <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="cadastro_email_field">
                E-mail
              </label>
              <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="email" id="cadastro_email_field" placeholder="Digite o seu E-mail" name="email" value="{{ old('email') }}" />
            </div>
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_senha">
                Senha
              </label>
              <div class="group relative">
                <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3" type="password" id="cadastro_senha" name="password" placeholder="Digite a sua senha" />
                <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                  <button type="button" data-inputId="cadastro_senha" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                    <img src="/images/PRF/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                    <img src="/images/PRF/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                  </button>
                </div>
                @error('password')
                  <p class="text-red-600">{{ $message }}</p>
                @enderror
                <div class="text-gray-1 text-sm mt-2">
                  <p>
                    a senha deve ter:
                  </p>
                  <ul>
                    <li>- Minimo de 8 caracteres</li>
                  </ul>
                </div>
              </div>
            </div>
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="confirm_password">
                Confirmação de senha
              </label>
              <div class="group relative">
                <input required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3" type="password" id="confirm_password" name="confirm_password" placeholder="Digite a sua senha" />
                <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                  <button type="button" data-inputId="confirm_password" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                    <img src="/images/PRF/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                    <img src="/images/PRF/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                  </button>
                </div>
              </div>
            </div>
          </div>

          <h2 class="text-gray-1 text-xl font-semibold font-poppins">
            Aceite obrigatório
          </h2>
          <hr class="my-4 border-gray-4" />
          <p class="text-sm text-gray-1 mb-8">
            “Aceito as regras de participação da MEIA MARATONA PRF 191 -
            POLICIAIS CONTRA O CÂNCER INFANTIL 2023 presentes no REGULAMENTO GERAL da
            competição e a POLÍTICA DE TRATAMENTO DE DADOS, nos limites das finalidades
            institucionais da H C PRODUÇÕES E EVENTOS LTDA - HC SPORTS, organizadora do evento,
            observando o norteamento jurídico da Lei 13.709/2018 (Lei Geral de Proteção de Dados –
            LGPD).”
          </p>
          <div class="flex items-center gap-2">
            <input data-conditional="submit_button" type="checkbox" id="cadastro_termos_checkbox" name="cadastro_termos_checkbox" class="checkbox" required />
            <a href="#" class="block pb-1 text-sm font-semibold text-brand-prfA1 underline">
              Li e aceito os termos.
            </a>
          </div>

          <hr class="mt-20 mb-8 border-gray-4" />

          <button disabled id="submit_button" data-conditional-button type="submit" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
            <p class="text-white text-sm font-bold font-poppins">
              Cadastrar-se
            </p>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        style: {
          background: "#EBFBEE",
          color: "#279424",
          boxShadow: "none",
        },
        onClick: function() {} // Callback after click
      }).showToast();
    }

    function showErrorToastfy(text) {
      Toastify({
        text: text,
        duration: 3000,
        gravity: "top",
        close: true,
        position: "right",
        style: {
          background: "#FBDBDB",
          color: "#8E1014",
          boxShadow: "none",
        },
        onClick: function() {} // Callback after click
      }).showToast();
    }

    new Cleave('#cadastro_cpf_field', {
      blocks: [3, 3, 3, 2],
      delimiters: ['.', '.', '-'],
      numericOnly: true,
    });

    new Cleave('#cadastro_date_field', {
      date: true,
      delimiter: '-',
      datePattern: ['Y', 'm', 'd']
    });
  </script>
@endsection
