<header>
    <style>
        .n_cart {
            position: relative;
        }

        .n_cart span {
            position: absolute;
            top: 0;
            font-size: 12px;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">HCsports</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link n_cart" href="/cart"><img src="/img/cart.svg" alt=""><span class="text-success">{{Count(Session('cart'))}}</span></a>
                    </li>
                    @if (Session::has('user'))
                    <li class="nav-item">
                        <a class="nav-link" href="/my-registrations">Minhas incrições</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>

                    @endif



                </ul>
            </div>
        </div>
    </nav>
</header>