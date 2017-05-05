@extends('layouts.front')
@section('content')
<div >
  <div class="">
    <div>
      <section  class="container" >
        <div class="row">
          <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <form id="activation-form" action="{{{route('user.account_activation_post', ['token'=> $token])}}}" method="POST">
                <div class="row">
                  <div class="col-xs-12"><h1>Activa tu cuenta</h1></div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="alert alert-success">
                      Completa tus datos, elige tu contrase&ntilde;a y  activa tu cuenta.
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label >Nombre Completo</label>
                      <input type="text" name="name" class="required form-control" value="{{{ $model->name }}}" >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Tipo de identificaci&oacute;n</label>
                      <select name="ide_type" class="required form-control" >
                        <option value="">Selecciona</option>
                        @foreach ($types as $type)
                          <option {{{ ($type->getKey() == $model->ide_type ? 'selected' : '' ) }}} value="{{{ $type->getKey() }}}">{{{ $type->name }}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >N&uacute;mero de identificaci&oacute;n</label>
                      <input type="text" name="ide" class="required form-control" value="{{{ $model->ide }}}" placeholder="">
                    </div>
                  </div>
                </div>    
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Email</label>
                      <input type="text" name="email" readonly class="required email form-control" value="{{{ $model->email }}}" >
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Tel&eacute;fono fijo</label>
                      <input type="text" name="phone" class="form-control" value="{{{ $model->phone }}}" >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Tel&eacute;fono de celular</label>
                      <input type="text" name="cell" class="form-control" value="{{{ $model->cell }}}" placeholder="">
                    </div>
                  </div>  
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Direcci&oacute;n</label>
                      <input type="text" name="address" class="form-control" value="{{{ $model->address }}}" placeholder="">
                    </div>
                  </div>      
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Tel&eacute;fono fijo de empresa</label>
                      <input type="text" name="job_phone" class="form-control" value="{{{ $model->job_phone }}}" placeholder="">
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Tel&eacute;fono celular de empresa</label>
                      <input type="text" name="job_cell" class="form-control" value="{{{ $model->job_cell }}}" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Direcci&oacute;n de empresa</label>
                      <input type="text" name="job_address" class="form-control" value="{{{ $model->job_address }}}" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <h4>Elige tu contrase&ntilde;a</h4>
                  </div>
                </div>
                 <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Contrase&ntilde;a</label>
                      <input type="password" name="password" class="form-control required" value="" id="password" placeholder="">
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label >Confirma tu contrase&ntilde;a</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" class="required form-control" value="" placeholder="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <div alert ></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 alig-right">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="btn btn-success">Guardar y activar</button>                  
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    &nbsp;<br>
                  </div>
                </div>
              </div> 
                <div class="clearfix"></div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@stop
@section('footer')  
    <script src="{{ asset('vendors/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/validate/localization/messages_'.config('app.locale').'.min.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.sendajax.js') }}"></script>
    <script src="{{ asset('js/scripts/activation.js') }}"></script>
@stop