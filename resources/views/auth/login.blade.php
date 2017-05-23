@extends('layouts.front')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Iniciar Sesi&oacute;n</div>
                <div class="panel-body">
                    <form id="login-form" class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="email" class="control-label">Correo electr&oacute;nico</label>                            
                                <input id="email" type="text" class="form-control email required" name="email" value=""  >                                
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="password" class="control-label">Contrase&ntilde;a</label>                            
                                <input id="password" type="password" class="form-control required" name="password" value=""  >                                
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" > Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div alert ></div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Olvidaste tu contrase&ntilde;a?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script src="{{ asset('vendors/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/validate/localization/messages_'.config('app.locale').'.min.js') }}"></script>    
       
    <script src="{{ asset('js/scripts/login.js') }}"></script>
@stop