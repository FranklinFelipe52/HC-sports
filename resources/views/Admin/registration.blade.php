<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atleta - Comprovante de inscrição</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="/frontend/dist/css/style.css">
</head>

<body class="h-screen">

  <!-- modal -->
  <div id="modal" class="hidden">
    <div class="flex h-screen w-full fixed bottom-0 bg-black bg-opacity-60 z-50 justify-center items-center">
      <div class="bg-white mx-3 p-3 md:p-6 rounded-lg w-full max-w-[532px]">
        <!-- modal header -->
        <div>
          <p class="text-gray-1 text-lg md:text-xl font-semibold">
            Tem certeza de que deseja excluir esta inscição?
          </p>
        </div>

        <hr class="mt-4 mb-3.5">

        <!-- modal body -->
        <div>
          <p class="text-gray-1 text-base">
            Esta ação é destrutiva e apagará todos os dados desta inscrição.
          </p>
        </div>

        <!-- modal footer - actions -->
        <div class="flex justify-end gap-4 flex-wrap mt-10">
          <a role="button" href="/admin/registration/delete/{{ $registration->id }}" class="flex text-brand-v1 text-sm font-bold font-poppins items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
            Excluir Inscrição
          </a>
          <button data-modalId="modal" data-action="close" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-black hover:ring-2 hover:ring-black hover:ring-opacity-50 bg-black transition">
            <p class="text-white text-sm font-bold font-poppins">
              Cancelar
            </p>
          </button>
        </div>
      </div>
    </div>
  </div>

  @include('components.admin.menu_mobile', ['type' => 4])

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.admin.menu_lateral', ['type'=> 0]);
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
    @if(Session('admin')->personification)
    @include('components.admin.personification_nav')
    @endif
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/src/pages/admin/atletas.html" class="text-xs text-gray-1 block hover:underline">
                Atletas
              </a>
            </div>
            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Comprovante de inscrição
            </div>
          </nav>
          <div class="flex gap-4 items-center flex-wrap">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              {{ $registration->user->nome_completo }}
            </h1>
            <div class="@if ($registration->status_regitration->id == 1) bg-feedback-fill-green @elseif ($registration->status_regitration->id == 3) bg-feedback-fill-purple @endif     py-1 px-1.5 rounded-full inline-block w-fit h-fit">
              <p class="@if ($registration->status_regitration->id == 1) text-feedback-green-1 @elseif ($registration->status_regitration->id == 3) text-feedback-purple @endif text-xs">
                {{ $registration->status_regitration->status }}
              </p>
            </div>
          </div>
        </header>

        <div class="w-full max-w-[700px]">
          <div class="border border-gray-5 rounded-lg mb-6">
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  CPF
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->user->cpf); ?>
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  E-mail
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->user->email }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Modalidade de interesse
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->modalities->nome }}
                </p>
              </div>
            </div>
            @if (!($registration->modalities->mode_modalities->id == 1))
              <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-1 font-semibold">
                    Categoria
                  </p>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-2 font-normal">
                    {{ $registration->modalities_category->nome }}
                  </p>
                </div>
              </div>
            @endif
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Pagamento via
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->type_payment->type }}
                </p>
              </div>
            </div>
            <!--<div class="grid grid-cols-2 gap-2 sm:gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Comprovante de pagamento
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <button class="inline-flex items-center gap-3 bg-fill-base p-2 pr-8 rounded-lg hover:bg-gray-6 transition">
                  <div class="w-[30px] h-[30px]">
                    <img src="/images/svg/link.svg" class="h-full w-full object-cover" alt="">
                  </div>
                  <p class="text-sm text-gray-1">
                    comprovante-inscrição.pdf
                  </p>
                </button>
              </div>
            </div>-->


          </div>
          <div class="flex flex-wrap justify-between gap-6">
            <button data-modalId="modal" data-action="open" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded border-[1.5px] border-brand-v1 hover:ring-2 hover:ring-brand-v1 hover:ring-opacity-50 bg-white transition">
              <img src="/images/svg/trash.svg" alt="">
              <p class="text-brand-v1 text-sm font-bold font-poppins">
                Excluir Inscrição
              </p>
            </button>
          </div>
        </div>
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
