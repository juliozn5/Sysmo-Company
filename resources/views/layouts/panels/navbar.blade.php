  <nav class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav align-items-center ml-auto">
          <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="{{($configData['theme'] === 'dark') ? 'sun' : 'moon' }}"></i></a></li>
        </li>
        <li class="nav-item dropdown dropdown-user">
          <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="user-nav d-sm-flex d-none">
              <span class="user-name font-weight-bolder">{{ Auth::user()->username }}</span>
              @if (Auth::user()->role == 1)
              <h5 class="user-status">Administrador</h5>
              @endif
            </div>
            <span class="avatar">
              <img class="round" src="{{asset('images/avatars/10-small.png')}}" alt="avatar" height="40" width="40">
              <span class="avatar-status-online"></span>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
            <a class="dropdown-item" href="{{ route('profile.show') }}">
              <i class="mr-50" data-feather="user"></i> Profile
            </a>
            <a>
              <form method="POST" class="pr-3 mr-3" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item pr-5 mb-0 float-start" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                  this.closest('form').submit();">
              <i class="mr-50" data-feather="power"></i> Logout
            </button>
                </form>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- END: Header-->
