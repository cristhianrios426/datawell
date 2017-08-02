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
                                                Completa tus datos, elige tu contrase&ntilde;a y  activa tu cuenta. Los datos con <span class="require-mark">*</span> son obligatorios
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Datos Principales</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >Nombre Completo <span class="require-mark">*</span></label>
                                                <input type="text" name="name" class="required form-control" value="{{{ $model->name }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de identificaci&oacute;n <span class="require-mark">*</span></label>
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
                                                <label >N&uacute;mero de identificaci&oacute;n <span class="require-mark">*</span> </label>
                                                <input type="text" name="ide" class="required form-control" value="{{{ $model->ide }}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Datos Corporativos</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Email</label>
                                                <input type="text" name="email" readonly class="required email form-control" value="{{{ $model->email }}}" >
                                                <p class="help-block">Este es tu correo electr&oacute;nico para inicio de sesi&oacute;n</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tel&eacute;fono fijo de empresa <span class="require-mark">*</span></label>
                                                <input type="text" name="job_phone" class="required form-control" value="{{{ $model->job_phone }}}" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tel&eacute;fono celular de empresa </label>
                                                <input type="text" name="job_cell" class="form-control" value="{{{ $model->job_cell }}}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Direcci&oacute;n de empresa / Ciudad / Pa&iacute;s <span class="require-mark">*</span></label>
                                                <input type="text" name="job_address" class="required form-control" placeholder="Calle 125 # 35 , Bucaramanga - Colombia" value="{{{ $model->job_address }}}" placeholder="">                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Cargo <span class="require-mark">*</span></label>
                                                <input type="text" name="cargo" class="required form-control" value="{{{ $model->cargo }}}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Dependencia <span class="require-mark">*</span> </label>
                                                <input type="text" name="dependencia" class="required form-control" value="{{{ $model->dependencia }}}" placeholder="">                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Datos Personales</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Email Personal</label>
                                                <input type="text" name="personal_email"  class="email form-control" value="{{{ $model->personal_email }}}" >
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
                                                <label >Tel&eacute;fono celular</label>
                                                <input type="text" name="cell" class="form-control" value="{{{ $model->cell }}}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Direcci&oacute;n / Ciudad / Pa&iacute;s</label>
                                                <input type="text" name="address" class="form-control" value="{{{ $model->address }}}" placeholder="">
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
                                                <label >Contrase&ntilde;a <span class="require-mark">*</span></label>
                                                <input type="password" name="password" class="form-control required" value="" id="password" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Confirma tu contrase&ntilde;a <span class="require-mark">*</span></label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="required form-control" value="" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="alert alert-info">
                                                La contrase&ntilde;a debe ser de m&iacute;nimo 8  caracteres y debe contener letras, may&uacute;sculas y min&uacute;sculas, n&uacute;meros.
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
<script src="{{ asset('js/scripts/activation.js') }}"></script>
@stop