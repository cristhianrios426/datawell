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
                        @if( !$model->exists )
                            <h4 class="modal-title">Nuevo {{{ $entityLabel }}}</h4>
                        @else
                            <h4 class="modal-title">Editando {{{ $entityLabel }}} {{{ $model->name }}}</h4>
                        @endif
                    </div>
                    <div class="panel-body">
                        <div class="fluid-container">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >Nombre  <strong class="require-mark">*</strong></label>
                                                <input type="text" name="name" class="require form-control required" value="{{{ $model->name }}}" >
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Pozo <strong class="require-mark">*</strong> </label>
                                                <select name="id_well"  data-live-search="true" class="selectpicker require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($wells as $well)
                                                      @if ($model->exists)
                                                        <option {{ ($model->id_well == $well->getKey() ? 'selected' : '' ) }} value="{{{ $well->getKey() }}}">{{{ $well->name }}}</option>
                                                      @else
                                                        <option {{ ($prewell == $well->getKey() ? 'selected' : '' ) }} value="{{{ $well->getKey() }}}">{{{ $well->name }}}</option>
                                                      @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de servicio <strong class="require-mark">*</strong></label>
                                                <select name="id_service_type"  class="selectpicker require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($serviceTypes as $serviceType)
                                                      <option {{ ($model->id_service_type == $serviceType->getKey() ? 'selected' : '' ) }} value="{{{ $serviceType->getKey() }}}">{{{ $serviceType->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de secci&oacute;n <strong class="require-mark">*</strong> </label>
                                                <select name="id_section"  data-live-search="true" class="selectpicker require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($sections as $section)
                                                      <option {{ ($model->id_section == $section->getKey() ? 'selected' : '' ) }} value="{{{ $section->getKey() }}}">{{{ $section->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Fecha de terminaci&oacute;n <strong class="require-mark">*</strong> </label>
                                                <input type="text" name="ended_at" class="form-control required date"  value="{{{ $model->ended_at }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                             <div class="form-group">
                                                <label >Descripci&oacute;n</label>
                                                <textarea name="description" class="form-control" id="" >{{{ $model->description }}}</textarea>
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
                                                          <input type="hidden" data-servername name="old_attachments[{{{ $key }}}][id]" value="{{{ $attachment->getKey() }}}">
                                                          <input data-removed type="hidden" data-servername name="old_attachments[{{{ $key }}}][deleted]" value="0">
                                                          <button data-remove class="btn btn-danger btn-xs">eliminar</button>
                                                      </div>
                                                  @endforeach
                                                @endif
                                            </div>
                                            <div class="btn btn-success relative" data-uploader="" >
                                                <span><i class="fa fa-cloud-upload" aria-hidden="true"></i> &nbsp;Adjuntar archivo</span>
                                                <input type="file" name="file" class="hidden-action">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                   <small>Los campos marcado son <strong class="require-mark">*</strong> son obligatorios</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div alert=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="{{{ url()->previous() }}}" class="btn btn-warning">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
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