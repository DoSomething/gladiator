<header role="banner" class="header">
    <div class="wrapper">
        <h1 class="header__title">{{ $title }}</h1>

        @if (isset($subtitle))
            <p class="header__subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</header>
