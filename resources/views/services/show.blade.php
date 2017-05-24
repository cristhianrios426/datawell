@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
    <form action="{{{ ( !$model->exists  ? route($entityName.'.store') : route($entityName.'.update',['id'=>$model->getKey()]))  }}}" method="{{{ ( !$model->exists  ? 'POST' : 'PUT' )  }}}">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="modal-title">Servicio: {{{ $model->name }}}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="fluid-container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >Nombre  <strong class="require-mark">*</strong></label>
                                                <div class="form-control">
                                                  {{{ $model->name }}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Pozo <strong class="require-mark">*</strong> </label>
                                                <div class="form-control">
                                                  {{{ $model->well ? $model->well->name : '' }}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de servicio <strong class="require-mark">*</strong></label>
                                                <div class="form-control">
                                                  {{{ $model->type ? $model->type->name : '' }}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de secci&oacute;n <strong class="require-mark">*</strong> </label>
                                                <div class="form-control">
                                                  {{{ $model->section ? $model->section->name : '' }}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Fecha de terminaci&oacute;n <strong class="require-mark">*</strong> </label>
                                                <div class="form-control">
                                                  {{{ $model->ended_at }}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                             <div class="form-group">
                                                <label >Descripci&oacute;n</label>
                                                <div class="form-control">
                                                  {{{ $model->description }}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Archivos adjuntos</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="list-files">
                                                @if ($model->exists)
                                                  @foreach ($model->attachments as $key => $attachment)
                                                       <div class="well " data-old-attachment >
                                                          <a href="{{{ $model->routeToAttachment($attachment->id) }}}" data-url target="_blank">
                                                              <div data-name="">{{{ $attachment->name }}}</div>
                                                          </a>
                                                      </div>
                                                  @endforeach
                                                @endif
                                            </div>                                            
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
                            <li><a href="{{{ route($entityName.'.index') }}}"  >Ver listado</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div style="display: none" id="template-file">
    <div class="well">
        <a href="#" data-url target="_blank">
            <div data-name=""></div>
        </a>
        <div data-progress=""></div>
        <input type="hidden" data-servername name="attachments[{id}][file]">
        <input type="hidden" data-clientname name="attachments[{id}][name]">
        <button data-remove="" class="btn btn-danger btn-xs">eliminar</button>
    </div>
</div>
@stop
@section('footer')
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('vendors/fileuploader/compiled.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.datawelluploader.js') }}"></script>
    <script src="{{ asset('js/scripts/entity.js') }}"></script>  
    <script src="{{ asset('js/scripts/jquery.sendajax.js?t='.time()) }}"></script>  
    <script src="{{ asset('js/scripts/service-controller.js?t='.time()) }}"></script>  
@stop