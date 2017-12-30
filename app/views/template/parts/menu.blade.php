<header class="main-header">
    <!-- Logo -->
    <a href="home" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>T</b>Chef</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Toque</b>Chef</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if(Auth::guest())
                    <li class="messages-menu">
                        <a href="{{ route('login') }}">
                            <i class="fa fa-sign-in"></i>
                            Log In
                        </a>
                    </li>
                @else
                    <li class="messages-menu">
                        <a href="{{ route('profile', Auth::user()->id) }}">
                            <i class="fa fa-user"></i>
                            Profil
                        </a>
                    </li>
                    <li class="messages-menu">
                        <a href="{{ route('logout') }}">
                            <i class="fa fa-sign-out"></i>
                            Log Out
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <form action="{{ route('search') }}" method="post" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Recherche ...">
                    <span class="input-group-btn">
                <button type="submit" name="launchSearch" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <li class="header">MENU</li>
            <!-- HOME -->
            <li {{ (Route::currentRouteName() == 'home') ? 'class=active' : '' }}>
                <a href="{{ route('home') }}">
                    <i class="fa fa-home"></i> <span>Accueil</span>
                </a>
            </li>
            @if(Auth::user())
                    <li {{ (Route::currentRouteName() == 'recipes.my') ? 'class=active' : '' }}>
                        <a href="{{ route('recipes.my') }}">
                            <i class="fa fa-cutlery"></i> <span>Mes Recettes <small class="label bg-blue pull-right">{{ count(Recipe::where('owner_id', Auth::user()->id)->get()) }}</small></span>
                        </a>
                    </li>
                <li {{ (Route::currentRouteName() == 'recipes.add') ? 'class=active' : '' }}>
                    <a href="{{ route('recipes.add') }}">
                        <i class="fa fa-plus"></i> <span>Ajouter une recette</span>
                    </a>
                </li>
            @endif
            <li {{ (Route::currentRouteName() == 'recipes.top') ? 'class=active' : '' }}>
                <a href="{{ route('recipes.top') }}">
                    <i class="fa fa-star"></i> <span>Top Recettes</span>
                </a>
            </li>
            <li {{ (Route::currentRouteName() == 'recipes.last') ? 'class=active' : '' }}>
                <a href="{{ route('recipes.last') }}">
                    <i class="fa fa-clock-o"></i> <span>Derniéres Recettes</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>