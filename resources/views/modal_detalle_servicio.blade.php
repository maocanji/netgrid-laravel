<div class="ibox">
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    <h2>Datos del Usuario : </h2>
                </div>
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <h3><strong>Información usuario</strong></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container row ">
            <form method="POST" action="{!! route('update_usuario') !!} ">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group row">
                    <label for="nombre" class="col-md-3">{{ __('Id') }}</label>
                    <div class="col-md-6">
                        <input id="identificador" name="identificador" disabled="disabled" type="text" class="form-control{{ $errors->has('identificador') ? ' is-invalid' : '' }}" value="<% usuario.id%>" required>
                        @if ($errors->has('identificador'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('identificador') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nombre" class="col-md-3">{{ __('Nombre') }}</label>
                    <div class="col-md-6">
                        <input id="name" name="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="<% usuario.name%>" required>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nombre" class="col-md-3">{{ __('Email') }}</label>
                    <div class="col-md-6">
                        <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="<% usuario.email%>" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>
