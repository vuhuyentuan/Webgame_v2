@php
    $i = 1;
    $languages = \App\Models\Language::where('status', 'show')->get();
    $locale = App::getLocale();
    $orders = DB::table('bills')
                    ->orderBy('created_at', 'desc')
                    ->where('status', 'pending')
                    ->distinct()
                    ->count();

    $rechages = DB::table('recharge_histories')
                    ->orderBy('created_at', 'desc')
                    ->where('status', 'unpaid')
                    ->distinct()
                    ->count();
    $sum = $orders + $rechages;
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ $sum }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"> {{ __('You have :total unpaid orders', ['total' => $sum]) }}</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.order_history') }}" class="dropdown-item">
            <i class="fa fa-gamepad mr-2"></i> {{ __('There are :total game orders', ['total' => $orders]) }}
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.recharge_history') }}" class="dropdown-item">
            <i class="fa fa-inbox mr-2"></i> {{ __('There are :total recharge point', ['total' => $rechages]) }}
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      @if(count($languages) > 0)
      <li class="dropdown">
        <a class="nav-link main-header-icon" data-toggle="dropdown" href="#">
            @foreach($languages as $language)
                @if($locale == $language->locale)
                    <div class="user-info flex-grow-1 d-flex">
                        @if($language->flag)
                            <span class="flag-icon mr-2 flag-icon-{{$language->flag}}" style="width:24px; height:22px"></span>
                        @endif
                    </div>
                @endif
            @endforeach
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          @foreach($languages as $language)
            @php if($language->locale == $locale) continue; @endphp

            <a class="dropdown-item" href="{{ route('langroute', $language->locale) }}">
                @if($language->flag)
                    <span class="flag-icon flag-icon-{{$language->flag}}"></span>
                @endif
                {{$language->name}}
            </a>
          @endforeach
        </div>
      </li>
      @endif
      <li class="nav-item nav-icon dropdown">
        <a href="#" class="nav-item nav-icon pr-0 search-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" class="rounded-circle user-photo" style="width:40px; height:40px">
            @else
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle user-photo" style="width:40px; height:40px">
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="width:230px">
            <div class="d-flex mt-2 ml-4 mr-4 mb-2">
                <div class="flex-shrink-0">
                    <div class="image">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" class="rounded-circle user-photo" style="width:40px; height:40px">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle user-photo" style="width:40px; height:40px">
                        @endif
                    </div>
                </div>&nbsp;&nbsp;&nbsp;
                <div class="flex-grow-1">
                    <span class="fw-semibold d-block">
                        <a href="{{ route('info') }}" class="user-name">{{ Auth::user()->name }}</a>
                    </span>
                    <small class="text-muted surplus">{{ __('Surplus') }} : <b class="text-danger">{{ number_format(Auth::user()->amount) }}</b> ???</small>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">
                <svg class="svg-icon mr-0 text-secondary" id="h-05-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Logout') }}
            </a>
        </div>
      </li>
    </ul>
  </nav>
