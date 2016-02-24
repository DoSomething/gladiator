<nav class="navigation -white -floating">
    <a class="navigation__logo" href="{{ URL::to('/') }}"><span>DoSomething.org</span></a>
    <a class="navigation__toggle js-navigation-toggle" href="#"><span>Show Menu</span></a>
    <div class="navigation__menu">
        <ul class="navigation__primary">
            <li>
                <a href="{{ URL::to('waitingrooms') }}">
                    <strong class="navigation__title">View All Waiting Rooms</strong>
                </a>
            </li>
            <li>
                <a href="{{ URL::to('waitingrooms/create') }}">
                    <strong class="navigation__title">Add Waiting Room</strong>
                </a>
            </li>
            <li>
                <a href="{{ URL::to('competitions') }}">
                    <strong class="navigation__title">View Competitions</strong>
                </a>
            </li>
            <li>
                <a href="{{ URL::to('competitions/create') }}">
                    <strong class="navigation__title">Add Competition</strong>
                </a>
            </li>
        </ul>
    </div>
</nav>
