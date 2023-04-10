<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar senha</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" href="/frontend/dist/css/style.css">
</head>

<body class="h-screen">
  <div class="lg:grid lg:grid-cols-7 xl:container">
    <div class="lg:sticky lg:top-0 lg:h-screen max-h-[1200px] lg:col-span-3 bg-white bg-[url('/images/background.png')] bg-cover bg-no-repeat">
      <div class="flex flex-col h-full">
        <header class="p-5">
          <a href="/src/index.html">
            <img src="/images/Olimpiadas-Concad.png" alt="" />
          </a>
        </header>
        <div class="p-8 pb-12 lg:p-8 my-auto">
          <div class="w-fit">
            <h1 class="text-4xl md:text-5xl font-semibold text-brand-v1 font-poppins">
              Alterar Senha
            </h1>
            <div class="bg-brand-a1 h-1 rounded-lg mt-3.5 mb-2 w-1/2"></div>
          </div>
          <p class="text-sm font-normal text-gray-1">
            Alteração de senha através do e-mail.
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
    <div class="bg-white h-full lg:col-span-4 px-8 py-20  flex flex-col justify-center">
      <div class="mx-auto w-full max-w-[327px]">
        <form method="post" action="/admin/password_reset" id="cadastro_formulario">
          @csrf
          <input type="hidden" name="token_email" value="{{ $token_email }}">
          <div class="space-y-4 mb-8">
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_senha_field">
                Senha
              </label>
              <div class="group relative">
                <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3" type="password" id="cadastro_senha_field" name="password" placeholder="Digite a sua senha" />
                <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                  <button type="button" data-inputId="input_senha_exemplo" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                    <img src="/images/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                    <img src="/images/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                  </button>
                </div>
              </div>
            </div>
            <div>
              <label class="text-dark-900 font-semibold text-base inline-block mb-2" for="cadastro_senha_confirm_field">
                Confirmação de senha
              </label>
              <div class="group relative">
                <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-a1 focus:outline-brand-a1 text-gray-1 placeholder:text-gray-3" type="password" id="cadastro_senha_confirm_field" placeholder="Digite a sua senha novamente" />
                <div class="absolute top-2.5 right-4 bg-white transition-all group-[.disabled]:bg-gray-6">
                  <button type="button" data-inputId="input_senha_exemplo" class="hover:bg-gray-200 group-[.disabled]:bg-gray-6  transition w-8 h-8 flex justify-center items-center rounded-full group">
                    <img src="/images/svg/eye.svg" alt="" class="hidden group-[.show]:block" />
                    <img src="/images/svg/eye-off.svg" alt="" class="block group-[.show]:hidden" />
                  </button>
                </div>
              </div>
            </div>
          </div>
          <button id="submit_button" data-conditional-button type="submit" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
            <p class="text-white text-sm font-bold font-poppins">
              Enviar
            </p>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- js -->
  <script type="module" src="/frontend/dist/js/index.js"></script>
</body>

</html>
