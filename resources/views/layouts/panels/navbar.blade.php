  <nav
      class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
      <div class="navbar-container d-flex content">
          <ul class="nav navbar-nav align-items-center ml-auto">
              {{-- <li class="nav-item d-none d-lg-block">BALANCE</a></li> --}}
              <li class="nav-item dropdown dropdown-user">
                  <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <div class="user-nav d-sm-flex d-none">
                          <span class="user-name font-weight-bolder">{{ Auth::user()->username }}</span>
                          @if (Auth::user()->role == 1)
                          <h5 class="user-status badge badge-primary">Administrador</h5>
                          @else
                          <h1 class="user-status badge badge-primary">Saldo: {{ Auth::user()->balance }} $</h5>
                          @endif
                      </div>
                      <span class="avatar">

                          @if (Auth::user()->profile_photo_path != NULL)
                          <button
                              class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                              <img class="h-12 w-12 rounded-full object-cover"
                                  src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username }}" />
                          </button>
                          @else
                          <button
                              class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                              <img class="h-12 w-12 rounded-full object-cover"
                                  src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->username }}"
                                  alt="{{ Auth::user()->username }}" />
                          </button>
                          @endif
                          @if (Auth::user()->status == 0)
                          <span class="avatar-status-busy"></span>
                          @else
                          <span class="avatar-status-online"></span>
                          @endif
                      </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                      <a class="dropdown-item" href="{{ route('profile.show') }}">
                          <i class="mr-50" data-feather="user"></i> Perfil
                      </a>
                      <a>
                          @if (session('impersonated_by'))
                          <a class="dropdown-item" href="{{ route('impersonate.stop') }}">
                              <i class="mr-50" data-feather="power"></i> Regresar
                          </a>
                          @else
                          <form method="POST" class="pr-3 mr-3" action="{{ route('logout') }}">
                              @csrf
                              <button class="dropdown-item mb-0 float-start" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 this.closest('form').submit();">
                                  <i class="mr-50" data-feather="power"></i> Cerrar sesion
                              </button>
                          </form>
                          @endif
                      </a>
                  </div>
              </li>
          </ul>
      </div>
  </nav>
  <!-- END: Header-->
