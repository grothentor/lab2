<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand superuser-header" href="{{ route('mainPage') }}">
            @lang('Main page')
        </a>
    </div>
    <ul class="nav navbar-nav">
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">@lang('Login')</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-superuser" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            @lang('Logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
        <li><a href="{{ url('admin/realty-params/') }}">@lang('realty-params')</a></li>
        @yield('extra-links')
    </ul>
</nav>
@include('layouts.includes.errors')
@include('layouts.includes.breadcrumbs')
