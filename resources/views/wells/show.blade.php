@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 >{{{ $model->name }}}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="fluid-container">
                            <div class="row">
                                <div class="col-xs-12">
                                    @include('wells.inner-show')
                                </div>
                                <div class="col-xs-12">
                                    <div class="fluid-container">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4>Archivos adjuntos</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach ($model->attachments as $attachment)
                                                <div class="col-xs-4">
                                                    <div class="well">
                                                        <a href="{{{ $model->routeToAttachment($attachment->getKey()) }}}" data-url target="_blank">
                                                            <div data-name=""> {{{ $attachment->name }}}</div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="panel-footer text-right">                        
                        <div class="btn-group">
                          <button class="btn btn-primary">Acciones</button>
                          <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="{{{ route($entityName.'.edit', ['id'=>$model->id]) }}}"  >Editar</a></li>
                            <li><a href="{{{ route('service.create',['id_well'=>$model->getKey()]) }}}"  >A&ntilde;adir servicio</a></li>
                            <li><a href="{{{ route($entityName.'.index') }}}"  >Ver listado</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@stop
@section('footer')
    <script src="{{ asset('vendors/fileuploader/compiled.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.datawelluploader.js') }}"></script>
    <script src="{{ asset('js/scripts/entity.js') }}"></script>  
      
    <script src="{{ asset('js/scripts/well-controller.js') }}"></script>  
@stop