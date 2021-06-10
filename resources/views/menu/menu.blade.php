<li class="nav-item {{ request()->is(['home','/']) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">Home</a>
</li>
<li class="nav-item {{ request()->is('*user*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user.index') }}">User</a>
</li>
<li class="nav-item {{ request()->is('*category') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('category.index') }}">Category</a>
</li>
<li class="nav-item {{ request()->is('*movie') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('movie.index') }}">Movie</a>
</li>
