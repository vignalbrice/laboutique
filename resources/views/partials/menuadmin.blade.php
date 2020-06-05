<nav class="navbar navbar-expand-lg navbar-dark bg-light">
    <div class="container">
        <div class="flex-columns">
            <a class="navbar-brand ml-2 text-dark menu-link" href="{{route('home')}}"><i class="fas fa-store-alt"></i> Boutique en ligne la maison
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @if (Auth::check())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{ route('home') }}">Retour à l'accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{ route('admin.index') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{ route('admin.create') }}">Ajouter un produit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{route('login')}}"><i class="fas fa-sign-in-alt"></i></a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
    </div>
</nav>