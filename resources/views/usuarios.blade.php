@extends('layouts_configuracion.app')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>lista <small>Todos los usuarios</small></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        @foreach ( $alluser as $users )
                            <div class="col-lg-3">
                            <div class="contact-box center-version">

                                <a href="#">

                                    <img alt="image" class="img-circle" src="img/a2.jpg">


                                    <h3 class="m-b-xs"><strong>{{ $users->name }}</strong></h3>

                                    <div class="font-bold">{{ $users->roles['0']['description'] }}</div>

                                </a>
                                <div class="contact-box-footer">
                                    <div class="m-t-xs btn-group">

                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
@endsection

