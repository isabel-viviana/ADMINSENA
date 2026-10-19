<nav class="sena-navbar navbar navbar-expand-lg" aria-label="Navegación principal">
    <div class="sena-navbar__inner container-fluid">
        <a class="sena-brand" href="{{ url('/') }}" aria-label="SENA, inicio">
            <img src="{{ asset('assets/png-clipart-logo-sena-la-granja-leaf-text.png') }}" alt="Logo SENA">
            <span><strong>SENA</strong><small>Servicio Nacional de Aprendizaje</small></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Abrir menú"><span class="fas fa-bars"></span></button>
        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/#contacto') }}">Contáctanos</a></li>
                <li class="nav-item"><button class="nav-search" type="button" data-search-trigger aria-label="Buscar"><i class="fas fa-search" aria-hidden="true"></i><span>Buscar</span></button></li>
                @auth
                @if (Auth::user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin') }}">Panel</a></li>
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('portal') }}">Mi Portal</a></li>
                @endif
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link border-0 bg-transparent" type="submit">Cerrar sesión</button>
                    </form>
                </li>
                <li class="nav-item sena-profile"><span class="profile-avatar"><i class="fas fa-user" aria-hidden="true"></i></span><span class="profile-copy"><small>{{ Auth::user()->role }}</small><strong>{{ Auth::user()->name }}</strong></span></li>
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                <li class="nav-item sena-profile"><span class="profile-avatar"><i class="fas fa-user" aria-hidden="true"></i></span><span class="profile-copy"><small>Visitante</small><strong>Administración pública</strong></span></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<div class="search-drawer{{ isset($searchQuery) ? ' is-open' : '' }}" data-search-drawer aria-hidden="{{ isset($searchQuery) ? 'false' : 'true' }}">
    <div class="search-drawer__inner">
        <label for="site-search">¿Qué estás buscando?</label>
        <form action="{{ route('home') }}" method="GET">
            <div>
                <input id="site-search" name="q" type="search" value="{{ $searchQuery ?? request('q') }}" placeholder="Buscar en el portal">
                <button type="button" data-search-close aria-label="Cerrar búsqueda">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </form>

        @if(isset($searchMessage) && $searchMessage)<p>{{ $searchMessage }}</p>
        @elseif(isset($searchResults) && count($searchResults) > 1)
        <div>
            <p>Resultados encontrados:</p>
            <ul>@foreach($searchResults as $searchResult)
                <li>
                    <a href="{{ $searchResult['url'] }}">{{ $searchResult['label'] }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
