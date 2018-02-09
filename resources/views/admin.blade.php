@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Menu</div>
                <div class="panel-body">
                    <a class="btn btn-default" href="{{route('user_table')}}">Utilizadores <i class="fa fa-users" aria-hidden="true"></i></a>
                    <a class="btn btn-default" href="{{route('type.doc.table')}}">Tipos de Documentos <i class="fa fa-file" aria-hidden="true"></i></a>
                    <a class="btn btn-default" href="{{route('user.depart')}}">Departamentos <i class="fa fa-building" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
