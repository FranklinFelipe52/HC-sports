<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar senha - Link enviado</title>

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
        <h1 class="text-gray-1 text-[28px]">
          Link enviado!
        </h1>
        <hr class="my-3">
        <p class="text-gray-1 text-base mb-10">
          Acesse o seu e-mail para encontrar o link de alteração de senha.
        </p>
        <a href="/admin/login" class="flex items-center justify-center gap-4 w-full px-4 py-2.5 rounded border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
          <p class="text-white text-sm font-bold font-poppins">
            Voltar para o Login
          </p>
        </a>
      </div>
    </div>
  </div>

    <!-- js -->
    <script type="module" src="/frontend/dist/js/index.js"></script>
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
    </script>
</body>

</html>
