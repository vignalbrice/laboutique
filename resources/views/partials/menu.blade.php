<nav class="navbar navbar-expand-lg navbar-dark bg-light">
    <div class="container">
        <div class="flex-columns">
            <a class="navbar-brand ml-2 text-dark menu-link" href="{{route('home')}}"><i class="fas fa-store-alt"></i> Boutique en ligne la maison
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class=" nav-item active">
                        <a class="nav-link text-dark menu-link" href="{{route('home')}}">{{ strtoupper('Accueil') }}<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{route('show_solde')}}">{{ strtoupper('soldes') }}</a>
                    </li>
                    @if(isset($categories))
                    @forelse($categories as $id => $title)
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{url('category', $id)}}">{{ strtoupper($title) }}</a>
                    </li>
                    @empty
                    <a class="dropdown-item text-dark menu-link" href="#">Aucunes catégories</a>
                    @endforelse
                    @endif
                </ul>
                @if (Auth::check())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark menu-link" href="{{ route('admin.index') }}">{{ strtoupper('Dashboard') }}</a>
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
                        <a class="nav-link text-dark" href="{{route('login')}}"><i class="fas fa-sign-in-alt"></i></a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
    </div>
</nav>