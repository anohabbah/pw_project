<nav class="navbar has-shadow is-fixed-top is-dark">
    <div class="container is-fullhd">
        <div class="navbar-brand p-l-15">
            <a href="{{ url('/') }}" class="navbar-item">
                {{ config('app.name', 'Laravel') }}
            </a>

            <div class="navbar-burger burger" data-target="navMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="navbar-menu p-r-15" id="navMenu">
            <div class="navbar-start"></div>

            <div class="navbar-end">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link" href="#">{{ Auth::user()->name }}</a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
