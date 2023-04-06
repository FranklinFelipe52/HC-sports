<header>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">HCsports</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">Dashboard</a>
                </li>
                @if (Session('admin')->rule->id == 1)
                <li class="nav-item">
                        <a class="nav-link" href="/admin/administradores">Administradores</a>
                    </li>
                @endif
                <li class="nav-item">
                        <a class="nav-link" href="/admin/modalidades">Modalidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">Atletas</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>