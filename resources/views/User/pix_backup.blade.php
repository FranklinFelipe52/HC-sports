<!DOCTYPE html>
<html lang="en">

<head>
    <x-head titulo="Minhas incrições" />
    <style>
        img {
            width: 320px;
            height: auto;
        }
    </style>

</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/inscricao/user/dashboard/my-registrations">Minhas incrições</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/inscricao/logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
    <section class="container py-4">
        <div class="p-0">
        @if (Session::has('erro'))
        <div class="alert alert-danger" role="alert">
            {{Session('erro')}}
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                <h3>Você tem 24h para pagar o Pix por esse Qrcode</h3>
                <img src="{{$pix['qr_codes'][0]['links'][0]['href']}}" alt="">
            </div>
        </div>
        
           
        </div>
    </section>  
    <x-footer />
</body>

</html>