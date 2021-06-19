/**
 * angular-my-modal provides a reusable way to do modals in AngularJS
 * check out documentation in http://angular-my-modal.stpa.co
 *
 * Copyright © 2014 Stewan Pacheco <talk@stpa.co>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the “Software”), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
"use strict";
(function() {
    var module = angular.module("stpa.modal", ["luegg.directives"]);
    module.directive('myModal', StpaModal);
    module.controller('StpaModalCtrl', StpaModalCtrl);
    
    module.filter('startFrom', function() {
        return function(input, start) {
            if(input) {
                start = +start; //parse to int
                return input.slice(start);
            }
            return [];
        }
    });

    //directive
    function StpaModal($modal, $http) {
        return {
            transclude: true,
            restrict: 'EA',
            template: '<a ng-click="open()" ng-transclude></a>',
            scope: {
                //controller: "@",
                //controllerAs: "@",
                name: "@",
                custom: "@",
                valor: "@",
                size: "@",                
                scope: "=scope",
                body: "@",
                bodyClass: "@"
            },
            link: function(scope, element, attrs, transclude) {
                
                scope.open = function() {
                    var modalInstance = $modal.open({
                        templateUrl: attrs.template? attrs.template+attrs.opciones : false,
                        template: !attrs.template ? function() {
                            var html = 'Sin template';                           
                            return html;
                        } : false,
                        controller: 'StpaModalCtrl',
                        controllerAs: 'StpaModalCtrl',
                        size: attrs.size ? attrs.size : 'sm', //lg - sm - md
                        backdrop: attrs.backdrop ? attrs.backdrop : true,
                        resolve: {
                            modalSetting: function() { 
                                    var _custom = scope.custom ? angular.fromJson( scope.custom ) : {};
                                    var _valor  = scope.valor ? angular.fromJson( scope.valor ) : {};
                                    _custom.accion.valor = _valor;
                                if(_custom.titulo == 'Validaciones Unidades de Apoyo'){
                                    angular.element(document.getElementById('ajax'+scope.valor)).html('<img src="/imagenes/ajax-loader.gif">');
                                }
                                
                                return _custom;                                 
                            },
                            modalScope: function() {
                                return scope.valor ? scope.valor : {};
                            }
                        }

                    });
                    
                    modalInstance.result.then(function( datos ) {
                        //console.debug(datos);                        
                        $http.post( datos.ruta , datos.variables)
                        .success( function( data, status, headers, config ) { 
                            if( data.error === false ){
                                if(attrs.objeto)
                                    angular.element( document.getElementById( attrs.modulo ) ).scope().modificarObjeto(attrs.objeto, attrs.valor, data.respuesta);
                                if(datos.recarga)
                                    window.location = datos.recarga;
                            } else {
                                alert( "Error" );
                            }                            
                        }).error( function( ){
                            alert( "Error" );
                        });
                    }, function() {
                        //console.debug('error');
                    });
                };
            }
        };
    }

    //directive controller
    function StpaModalCtrl($scope, $http, $rootScope, $modalInstance, $compile, modalSetting,modalScope ) {

        var that     = this;
        that.setting = modalSetting;
        that.scope   = modalScope;
        that.accept  = accept;
        that.cancel  = cancel;

        that.seleccionar            = seleccionar;
        that.buscar                 = buscar;
        that.validarURL             = validarURL;
        that.enviarMensajeUA        = enviarMensajeUA;
        that.confirmarCambioUA      = confirmarCambioUA;
        
        $scope.elementoSeleccionado = {};
        $scope.currentPage          = 1;
        $scope.numPerPage           = 10;
        
        $scope.confirmarUA          = false;
        $scope.alertaUA             = false;
        $scope.classUA              = "warning";
        $scope.alertaMsnUA          = "Cambiando de estado, un momento por favor...";
        $scope.mensajeUA            = "";
        $scope.estadoUA             = "";        
        $scope.productoUA           = modalScope;
        $scope.unidadapoyo          = modalSetting.unidadapoyo;
        
           
        if ( $scope.unidadapoyo !== undefined ) {
            
            $http.post( modalSetting.rutaMensajes , {
                producto : $scope.productoUA
            }).success( function( data, status, headers, config ) {
                $scope.isChecked = data.ultimo;    
                $scope.lastChecked = data.ultimo;    
                $scope.mensajes = data.mensajes;
                $scope.productoRecomendaciones = data.producto;
                angular.element(document.getElementById('ajax'+$scope.productoUA)).html('');
                if(data.estrella == false){
                    angular.element(document.getElementById('estrella'+$scope.productoUA)).addClass('hidden');
                }
            }).error( function( ){
                alert( "Error" );
            });
        };

        //////////////////////
        // callback trigger //
        //////////////////////
        function accept(e) {
            angular.forEach( $scope.accion.variables , function( variable , key) {                 
               if ( variable == "" ) {
                   $scope.accion.variables[key] = $scope.elementoSeleccionado;
               }else if( key == "valor" ){
                    $scope.accion.variables[variable] = $scope.accion.valor;
               }else if( $scope.url ){
                    $scope.accion.variables['url'] = $scope.url;
               }else{
                    $scope.accion.variables[key] = variable;
               }    
           });
            
            $modalInstance.close( $scope.accion );
            $rootScope.$emit('StpaModalAccepted', e);
            if (e) e.stopPropagation();
        };

        function cancel(e) {
            $modalInstance.dismiss('cancel');
            $rootScope.$emit('StpaModalCanceled', e);
            if (e) e.stopPropagation();
        };

        function seleccionar ( elemento ) {
            $scope.elementoSeleccionado = elemento ;
            $scope.habilitar = false;
        };

        function buscar ( datos ){
            $scope.habilitar = true;
            datos.criterio = $scope.criterio;
            $http.post( datos.ruta , { datos } )
            .success( function( data ) { 
                $scope.elementos    = angular.fromJson( data.elementos );                
                $scope.totalItems   = $scope.elementos.length;              
            }).error( function( ){
                alert( "Error" );
            });
        };

        function validarURL ( url ){
            $http.post( '/grilla/verificar/urlValida' , { _url:url } )
            .success( function( data ) { 
                $scope.mensaje = data.mensaje;
                if( data.error === false ){
                    $scope.url = url; 
                    accept();
                }else{
                    console.log('no salir');
                    return false;
                }
            }).error( function( ){
                $scope.mensaje = "Error";
            });
        };

        function confirmarCambioUA( estado ){
            $scope.estadoUA = estado;
            if($scope.lastChecked != estado){
                $scope.confirmarUA = false;
                $scope.alertaUA = false;
                $scope.confirmarUA = true;
            }                
        }

        function enviarMensajeUA ( rh, producto, msn, estado,rolUA, rolDato, idProducto) {                
            
            $scope.lastChecked = estado;
            $scope.confirmarUA = false;
            $scope.alertaUA = true;
            $scope.enviaDisable=true;
            $http.post( '/grilla/verificar/unidadApoyo' , { 
                        cod_rh:rh , 
                        cod_producto:producto , 
                        estado: estado, 
                        comentarios:msn, 
                        rolDato:rolDato, 
                        unidad_apoyo:rolUA} )
            .success( function( data ) { 
                $scope.alertaUA     = false;
                $scope.mensajeUA = "";   
                
                angular.element( document.getElementById( 'grillaApp' ) ).scope().modificarEstadoi(idProducto, estado);
                $scope.mensajes = angular.fromJson( data.mensajes.mensajes );                                                                                   
                
                
                
                $scope.classUA      = data.class;
                $scope.alertaMsnUA  = data.mensaje;    
                $scope.alertaUA     = true;
                setTimeout( function () { $scope.alertaUA = false; }, 2000 );    
                $scope.enviaDisable=false;
                
                
            }).error( function( ){
                $scope.mensaje = "Error";
                $scope.enviaDisable=false;
            });
        }

        ///////////////////
        // event trigger //
        ///////////////////

        $rootScope.$on('StpaModalAccept', function() {
            accept();
        });
        $rootScope.$on('StpaModalCancel', function() {
            cancel();
        });
        $rootScope.$on('StpaModalSeleccionar', function( elemento ) {
            seleccionar( elemento );
        });
        $rootScope.$on('StpaModalBuscar', function( datos ) {
            buscar();
        });
        $rootScope.$on('StpaModalValidarURL', function( url ) {
            validarURL( url );
            accept();
        });
        $rootScope.$on('StpaModalconfirmarCambioUA', function( estado, anterior ) {            
            confirmarCambioUA( estado, anterior );
        });
        $rootScope.$on('StpaModalenviarMensajeUA', function( rh, producto, msn ) {            
            enviarMensajeUA( rh, producto, msn );
        });         
    }

})();