<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HC Sports</title>

  {{-- favicon --}}
  <link rel="icon" href="/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="/css/app.css">
</head>

<body class="h-screen">

  <div class="min-h-[100vh] flex flex-col justify-between">
    <header class="border-b border-gray-5 py-2">
      <div class="container mx-auto">
        <a href="/">
          <img src="/images/logo-hc.png" alt="">
        </a>
      </div>
    </header>

    <main class="container grow py-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="border border-gray-7 rounded-xl overflow-hidden">
          <div class="bg-brand-prfA1 border-b border-gray-7 flex justify-center items-center p-4 h-[153px]">
            <img src="/images/PRF/logo-prf.png" alt="">
          </div>
          <div class="p-3.5 border-b border-gray-5">
            <p class="font-bold text-sm font-poppins mb-1 text-dark-1">
              Maratona da Polícia Federal
            </p>
            <p class="font-medium text-xs font-poppins text-gray-3">
              Natal, 11 de novembro de 2023
            </p>
          </div>
          <div class="px-3.5 py-3">
            <p class="font-bold text-sm font-poppins mb-1 text-gray-2">
              inscrições de 20/07 à 31/07
            </p>
          </div>
          <div class="px-3.5 pt-3 pb-4 flex justify-center">
            <a href="/prf" class="bg-brand-prfA1 hover:ring-opacity-50 hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
              Inscreva-se
            </a>
          </div>
        </div>
        <div class="border border-gray-7 rounded-xl overflow-hidden">
          <div class="bg-white border-b border-gray-7 flex justify-center items-center p-4 h-[153px]">
            <img src="/images/logo-oab.png" alt="">
          </div>
          <div class="p-3.5 border-b border-gray-5">
            <p class="font-bold text-sm font-poppins mb-1 text-dark-1">
              Jogos da OAB
            </p>
            <p class="font-medium text-xs font-poppins text-gray-3">
              Natal, 11 de novembro de 2023
            </p>
          </div>
          <div class="px-3.5 py-3">
            <p class="font-medium italic text-sm font-poppins mb-1 text-gray-3">
              inscrições encerradas
            </p>
          </div>
          <div class="px-3.5 pt-3 pb-4 flex justify-center">
            <a href="/login" class="bg-brand-v2 hover:ring-opacity-50 hover:ring-2 transition-all hover:ring-brand-v2 text-sm font-poppins font-medium text-white flex items-center justify-center py-2.5 px-3.5 w-full max-w-[180px]">
              Acesse o Painel
            </a>
          </div>
        </div>
      </div>
    </main>

    <footer class="bg-fill-1 pt-16 pb-8 bottom-0 w-full">
      <div class="container border-t border-gray-3">
        <div class="grid grid-cols-1 md:grid-cols-2 pt-4 gap-4">
          <div>
            <p class="text-xs text-gray-1">
              <?= date('Y') ?> HC Sports. Todos os direitos reservados.
            </p>
          </div>
          <div class="flex justify-end gap-4">
            <a href="https://www.youtube.com/@hcsports6389" target="_blank">
              <img src="/images/svg/youtube.svg" alt="">
            </a>
            <a href="https://twitter.com/HCSportsBR" target="_blank">
              <img src="/images/svg/twitter.svg" alt="">
            </a>
            <a href="https://www.facebook.com/HCSportsBR" target="_blank">
              <img src="/images/svg/facebook.svg" alt="">
            </a>
            <a href="https://www.instagram.com/hcsportsbr/" target="_blank">
              <img src="/images/svg/instagram.svg" alt="">
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <!-- js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script type="module" src="/js/app.js"></script>
</body>

</html>
