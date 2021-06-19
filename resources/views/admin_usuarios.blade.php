@extends('layouts_configuracion.app')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Basic form <small>Todos los usuarios</small></h5>
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
                    <div ng-app="welcomeApp" ng-controller="welcomeCtrl"  class="ng-scope">

                        <div class="row" ng-repeat="user in alluser ">


                                <tr class="col-md-3">
                                    <div class="contact-box center-version">
                                    <a href="#">
                                        <img alt="image" class="img-circle" src="img/a2.jpg">
                                        <h3 class="m-b-xs"><strong><% user.name %></strong></h3>
                                        <div class="font-bold"><% user.email %></div>
                                    </a>
                                    <div class="contact-box-footer">
                                        <div class="m-t-xs btn-group">
                                            <button type="button" class="btn btn-outline btn-success" ng-click="modal_servicios_detalle(user.id);" >Ver Datos</button>
                                            <button type="button" class="btn btn-outline btn-danger" ng-click="delete_user(user.id);" >Eliminar</button>
                                        </div>
                                    </div>
                                    </div>
                                </tr>



                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/angular/angular.min.js') }}"></script>
    <script src="{{ asset('js/angular/ui-bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/angular/ngTable/ng-table.js') }}"></script>

            <script>


                function scrollToAnchor(aid){
                    var aTag = $("a[name='"+ aid +"']");
                    $('html,body').animate({scrollTop: aTag.offset().top},'slow');
                }
                var angularApp = angular.module( 'welcomeApp', [ 'ui.bootstrap','ngTable'] );
                angularApp.config(function($interpolateProvider , $httpProvider) {
                    $interpolateProvider.startSymbol('<%');
                    $interpolateProvider.endSymbol('%>');
                    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
                });

                angularApp.controller( 'welcomeCtrl', function(   $scope , $http, $timeout, $location, $log, $filter, $modal, ngTableParams,$rootScope ){
                    /*Inicializar variables*/
                    $scope.alluser = {!! $alluser !!};

                    $scope.modal_servicios_detalle = function(codificacion) {
                        var codificacion = codificacion;
                        // console.log(codificacion);
                        $scope.ruta = '{!! route( "traer_servicios" ) !!}' ;
                        /*Se envían los datos del formulario por ajax*/
                        $http.post( $scope.ruta ,
                            {
                                codificacion : codificacion,
                            }).then( function( responsive) {
                            var modalInstance = $modal.open({
                                animation: $scope.animationsEnabled,
                                templateUrl: '{!! route( "modal_detalle_servicios" ) !!}',
                                // templateUrl: 'mis_datos.modal_detalle_servicio.php',
                                controller: 'Modal_procesos_Ctrl',
                                backdrop: true,
                                backdropClick: false,
                                dialogFade: true,
                                keyboard: true,
                                size: 'lg',
                                resolve: {
                                    /* Se envía una variable con el registro que se va a borrar */
                                     usuario: function () {
                                         return responsive.data.usuario;
                                     }
                                    // ,ordenes: function () {
                                    //     return responsive.data.orden[0];
                                    // },etapas: function () {
                                    //     return responsive.data.etapas;
                                    // }
                                }
                            });

                        }).catch( function( data ){
                            console.log(data);
                        });
                    };
                    $scope.delete_user = function (index) {
                        var id_eliminar = index;
                        console.log(id_eliminar);
                        $scope.ruta = '{!! route( "eliminar_usuario" ) !!}',{};
                        /*Se envían los datos del formulario por ajax*/
                        $http.post( $scope.ruta ,
                            {
                                id_eliminar :   id_eliminar
                            }).then( function( responsive) {

                        }).catch( function( data ){
                            console.log(data);
                        });

                    };

                });
                angularApp.controller('Modal_procesos_Ctrl', function ($scope, $log,$http, $modalInstance,usuario){
                     $scope.usuario = usuario;

                    $scope.submitFormUpdate_proceso = function (Form) {

                        $scope.ruta = '{!! route( "update_usuario" ) !!}';
                        /*Se envían los datos del formulario por ajax*/
                        $http.post( $scope.ruta ,
                            {
                                Form :  Form ,
                            }).then( function( responsive) {

                            $modalInstance.close();

                        }).catch( function( data ){
                            toastr.danger('problemas', 'DAE admin');
                        });

                    };

                });

            </script>

@show


