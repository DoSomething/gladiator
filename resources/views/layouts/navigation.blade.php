<nav class="navigation -white -floating">
    <a class="navigation__logo" href="/"><span>DoSomething.org</span></a>
    <a class="navigation__toggle js-navigation-toggle" href="#"><span>Show Menu</span></a>
    <div class="navigation__menu">
        @if (Auth::user())
            <ul class="navigation__primary">
                <li>
                    <a href="{{ URL::to('contests') }}">
                        <strong class="navigation__title">Contests</strong>
                        <span class="navigation__subtitle">Open, Close, Split</span>
                    </a>
                </li>
                <li>
                    <a href="{{ URL::to('users') }}">
                        <strong class="navigation__title">Users</strong>
                        <span class="navigation__subtitle">Admins, Staff, Contestants</span>
                    </a>
                </li>
                <li>
                    <a href="/">
                        <strong class="navigation__title">Settings</strong>
                        <span class="navigation__subtitle">App Configuration</span>
                    </a>
                </li>
            </ul>
        @endif

        <ul class="navigation__secondary">
            <li>
                @if (Auth::user())
                    <a href="/auth/logout">Logout</a>
                @else
                    <a href="/auth/login">Login</a>
                @endif
            </li>
        </ul>
    </div>
</nav>
