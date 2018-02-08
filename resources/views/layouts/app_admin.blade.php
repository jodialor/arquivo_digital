<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

  @include('includes/head')
  
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
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
                        @if(Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            @else
                                  <li>
                                     <a href="{{route('admin_menu')}}" class="dropdown-toggle"  role="button" aria-expanded="false">
                                       Menu
                                     </a>
                                  </li>
                                  <li class="dropdown">
                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                          {{ Auth::user()->name }} <span class="caret"></span>
                                      </a>

                                      <ul class="dropdown-menu" role="menu">
                                          <li>
                                              <a href="{{route('admin.logout')}}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                   <i class="fa fa-power-off" aria-hidden="true"></i> Logout
                                              </a>
                                              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                  {{ csrf_field() }}
                                              </form>
                                          </li>
                                      </ul>
                                  </li>
                            @endif
                        </a>
         </div>
       </div>
     </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script>
    $(document).ready(function() {
      $('#example').DataTable( {
        "columnDefs":[{
          "targets": 'no-sort',
          "orderable": true,
        }],
        "order": [[ 0, "desc" ]]
      } );
    } );
    </script>
</body>
</html>
