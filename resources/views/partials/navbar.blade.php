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
                <li class=""><a href="/dashboard/users">Users</a></li>
                <li class=""><a href="/dashboard/domains">Domains</a></li>
            @endif
        </ul>
        <form class="navbar-form navbar-left">
        </form>
        <ul class="nav navbar-nav navbar-right">
            <!-- <li><a href="javascript:void(0)">Notifications</a></li> -->
            <li class="dropdown">
                <a href="javascript:void(0)" data-target="#" class="dropdown-toggle" data-toggle="dropdown">
                    Account<b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    @if (Auth::guest())
                        <li><a href="{{route('auth.login')}}">Login</a></li>
                    @else
                        <li><a href="#">Lagged as: {{ Auth::user()->name }}</a></li>
                        <li><a href="{{ url('auth/logout') }}">Logout</a></li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>