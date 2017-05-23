@extends('layouts.front')
@section('content')
<section  class="container" >
    <div class="row">
      <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="fluid-continer">
              <div class="row">
                  <div class="col-xs-12"><h1>Error URL de activaci&oacute;n</h1></div>
              </div>
              <div class="row">
                  <div class="col-xs-12">
                    <div class="alert alert-warning">
                      El token de activaci&oacute;n est&aacute; errado, ha expirado o tu usuario est&aacute; inactivo
                    </div>
                  </div>
              </div>
            </div>
        </div>
      </div>
    </div>
</section>
@stop
@section('footer')  
    <script src="{{ asset('vendors/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/validate/localization/messages_'.config('app.locale').'.min.js') }}"></script>
    
    <script src="{{ asset('js/scripts/activation.js') }}"></script>
@stop