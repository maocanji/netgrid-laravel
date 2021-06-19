@extends('layouts_configuracion.app')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Clima <small>Informaciòn consultada de Weather </small></h5>
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
                        <div class="links">
                            <br>
                            <strong>Ciudad :</strong> {{ $forecast->city->name }} / <strong>Pais : </strong>{{$forecast->city->country }}
                            <br>
                            @if (count($forecast->list))
                                <br>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Weather</th>
                                        <th scope="col">Fechas </th>
                                        <th scope="col">Temperatura / Wather</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($forecast->list as $f)
                                        <tr>
                                            <td>
                                                 Cielo : {{ $f->weather[0]->description }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($f->dt_txt)->toFormattedDateString('l jS \\of F Y h:i:s A')}}
                                            </td>
                                            <td>
                                               Vel : {{ $f->wind->speed }}  <br> Temperatura {{ $f->main->temp}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <li>No hay pronostico</li>
                            @endif

                        </div>


                        </div>
                    </div>



                </div>

            </div>
        </div>
@endsection


