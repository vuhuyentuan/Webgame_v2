<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: linear-gradient({{ $setting->main_color }}, {{ $setting->main_color }}, {{ $setting->secondary_color }})">
    <!-- Brand Logo -->
    <a href="{{ route('index') }}" class="brand-link">
        <center> <img width="100%" height="50px" src="{{ asset($setting->logo) }}"></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ URL::current() == route('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link {{ URL::current() == route('products.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gamepad"></i>
                    <p>{{ __('Games') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.order_history') }}" class="nav-link {{ URL::current() == route('admin.order_history') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>{{ __('Order history') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.recharge_history') }}" class="nav-link {{ URL::current() == route('admin.recharge_history') ? 'active' : '' }}">
                    <i class="nav-icon fa fa-money-bill"></i>
                    <p>{{ __('Recharge history') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ URL::current() == route('users.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('banks.index') }}" class="nav-link {{ URL::current() == route('banks.index') ? 'active' : '' }}">
                    <i class="fas fa-credit-card nav-icon"></i>
                    <p>{{ __('Banks') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('slides.index') }}" class="nav-link {{ URL::current() == route('slides.index') ? 'active' : '' }}">
                    <i class="fa fa-list-alt nav-icon"></i>
                    <p>{{ __('Slides') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-hammer"></i>
                    <p>
                        {{ __('Tools') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('languages.index') }}" class="nav-link {{ URL::current() == route('languages.index') ? 'active' : '' }}">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-language"></i>
                            <p>{{ __('Language') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('translations.index') }}" class="nav-link {{ URL::current() == route('translations.index') ? 'active' : '' }}">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-globe"></i>
                            <p>{{ __('Translation') }}</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('contacts.index') }}" class="nav-link {{ URL::current() == route('contacts.index') ? 'active' : '' }}">
                    <i class="fas fa-phone nav-icon"></i>
                    <p>{{ __('Contact') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link {{ URL::current() == route('settings.index') ? 'active' : '' }}">
                    <i class="fas fa-cog nav-icon"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
            <li class="nav-header"></li>
            <li class="nav-item"></li>
        </ul>

    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
