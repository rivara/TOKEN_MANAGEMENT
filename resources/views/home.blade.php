@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="{{route('goUser')}}" method="GET">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa  fa-desktop"></i>
                                            <span>gestion de usuarios</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form class="floatLeft" action="{{route('goToken')}}" method="GET">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa  fa-desktop"></i>
                                            <span>gestion de tokens</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
