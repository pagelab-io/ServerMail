<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"></a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
            @if (Auth::user())
                <li class=""><a href="/dashboard/users">Usuarios</a></li>
                <li class=""><a href="/dashboard/domains">Dominios</a></li>
            @endif
        </ul>
        <form class="navbar-form navbar-left">
        </form>

        @if (!Auth::guest())
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0)" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                        Account<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ Auth::user()->name }}</a></li>
                        <li><a href="{{ url('auth/logout') }}">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        @endif

    </div>
</nav>