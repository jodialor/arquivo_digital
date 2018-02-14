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
      $('#docs_results').DataTable( {
        "columnDefs":[{
          "targets": 'no-sort',
          "orderable": true,
        }],
        //ordenação descendente da tabela dos documentos, por numero
        /*"order": [[ 0, 'desc' ]]*/
        //nenhuma ordenação por defeito (ela é feita diretamente na query)
        "order": []
      } );
    } );
    </script>
</body>
</html>
