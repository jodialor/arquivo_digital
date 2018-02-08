<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    @include('includes/head')
    
<body>
        @include('includes/header')
        @yield('content')
    </div>

    <div>
      @include('_footer')
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
