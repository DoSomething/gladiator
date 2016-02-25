<nav class="navigation -white -floating">
    <a class="navigation__logo" href="/"><span>DoSomething.org</span></a>
    <a class="navigation__toggle js-navigation-toggle" href="#"><span>Show Menu</span></a>
    <div class="navigation__menu">
        @if (Auth::user())
            <ul class="navigation__primary">
                <li>
                    <a href="{{ URL::to('waitingrooms') }}">
                        <strong class="navigation__title">Waiting Rooms</strong>
                        <span class="navigation__subtitle">Contestant Limbo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ URL::to('competitions') }}">
                        <strong class="navigation__title">Competitions</strong>
                        <span class="navigation__subtitle">Contestant groups</span>
                    </a>
                </li>
                <li>
                    <a href="/">
                        <strong class="navigation__title">Users</strong>
                        <span class="navigation__subtitle">Admins, Staff, Members</span>
                    </a>
                </li>
                <li>
                    <a href="/">
                        <strong class="navigation__title">Settings</strong>
                        <span class="navigation__subtitle">App configuration</span>
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
