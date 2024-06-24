<!DOCTYPE html>
<html lang="en">

<head>
    <x-head titulo="Minhas incrições" />
    <style>
        .item-modalidade {
            transition-duration: 0.8s;
        }

        .item-modalidade:hover {
            filter: grayscale(80%);
            transform: scale(1.005);
            transition-duration: 0.5s;
        }

        .hidden {
            overflow: hidden;
        }
    </style>

</head>

<body>
    <header>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a target="_self" class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a target="_self" class="nav-link" href="/user/dashboard/my-registrations">Minhas incrições</a>
                        </li>

                        <li class="nav-item">
                            <a target="_self" class="nav-link" href="{{route('logout')}}">Logout</a>
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
        <div class="row">
            <div class="col-3 d-flex flex-column align-items-center gap-3 card p-4">
                <h3>Pagar com cartão de credito</h3>
                <a target="_self" class="btn btn-primary" href="/card/{{$registration->id}}" role="button">Pagar</a>
            </div>
            <div class="col-3 d-flex flex-column align-items-center gap-3 card p-4">
                <h3>Pagar com pix</h3>
                <a target="_self" class="btn btn-primary" href="/pix/{{$registration->id}}" role="button">Pagar</a>
            </div>
        </div>
        </div>
    </section>
    
    
</body>

</html>