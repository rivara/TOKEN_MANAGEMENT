@extends('layouts.app')
@section('content')

    <div class="container">


        <div class="subtitle">
            <h4>Administración tokens</h4>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-2">
                <form class="floatLeft" method="GET" action="{{route('index')}}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-square-o"></i>
                        <span> volver</span>
                    </button>
                </form>
            </div>
            <div class="col-md-10"></div>
        </div>

        <br>
        <table class="table table-striped table-bordered " border="1px solid black">
            <thead>
            <th>ID</th>
            <th>Usuario/Entidad</th>
            <th>Titulo</th>
            <th>Token</th>
            <th>Fecha</th>
            <th></th>
            <th>
                <form class="floatLeft" method="GET" action="{{route('goTokensRegister')}}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-square-o"></i>
                        <span>+ añadir</span>
                    </button>
                </form>
            </th>
            </thead>
            <tbody>
            @foreach($paginado as $value)
                <tr>
                    @csrf
                    <td>{{$value->id}}</td>
                    <td>{{$value->usuario}}</td>
                    <td>{{$value->titulo}}</td>
                    <td>{{$value->token}}</td>
                    <td>{{$value->created_at}}</td>
                    <td>
                        <button type="button" class="delete btn btn-danger" data-toggle="modal"
                                data-target="#confirm" value={{$value->id}}>
                            eliminar
                        </button>
                    </td>
                     <td>
                        <form class="float-left" method="GET" action="{{route('goUpdateToken')}}">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-square-o"></i>
                                <span> editar</span>
                            </button>
                            <input type="hidden" name="id" id="id" value="{{$value->id}}">
                        </form>
                     </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row floatLeft ">
            <div class="col-md-12">
            </div>

        </div>
    </div>
    <!-- Modal Dialog -->
    <div class="modal fade" id="confirm" aria-labelledby="confirmDeleteLabel">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>¿Desea borrar este token?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

                    <form action="{{route('deleteToken')}}" method="GET">
                        <button type="submit" name="submit" value="Delete" class="btn btn-danger ">
                            borrar
                        </button>
                        <input type="hidden" name="idd" id="idd">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

