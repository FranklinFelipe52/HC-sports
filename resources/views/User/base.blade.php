<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>

  {{-- favicon --}}
  <link rel="icon" href="/inscricao/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="/inscricao/favicon.png" type="image/x-icon">

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="/inscricao/css/app.css">
</head>

<body class="h-screen">

  @yield('content')

  <!-- js -->
  <script type="module" src="/inscricao/js/app.js"></script>
</body>

</html>
