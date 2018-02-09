<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        <span class="logo-mini"><font size="6"><p><i class="fa fa-archive" aria-hidden="true"></i> Arquivo Digital de Documentação &nbsp;&nbsp;</p></font></span>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <!-- Left Side Of Navbar -->
      <ul class="nav navbar-nav">
          &nbsp;
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="nav navbar-nav navbar-right">
          <!-- Authentication Links -->
          @if(Auth::guard('admin')->check())
            <li><a href="{{ route('admin_menu') }}">Admin Menu</a></li>
          @endif
          @if(Auth::guest())
              <li class="{{ Request::is('login') ? "active" : "" }}"><a href="{{ route('login') }}">Login</a></li>
              <li class="{{ Request::is('register') ? "active" : "" }}"><a href="{{ route('register') }}">Registar</a></li>
          @else
              <li>
                 <a href="{{route('dashboard')}}" class="dropdown-toggle"  role="button" aria-expanded="false">
                   Documentos
                 </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{route('logout')}}">Logout</a>
                    </li>
                </ul>
              </li>
          @endif
          </a>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
