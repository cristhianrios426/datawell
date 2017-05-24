@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
    <form form-save action="{{{ ( !$model->exists  ? route($entityName.'.store') : route($entityName.'.update',['id'=>$model->getKey()]))  }}}" method="{{{ ( !$model->exists  ? 'POST' : 'PUT' )  }}}" id="save-service">
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
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Nombre  <strong class="require-mark">*</strong></label>
                                                <input type="text" name="name" class="require form-control required" value="{{{ $model->name }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Unidad de negocios<strong class="require-mark">*</strong></label>
                                                <select business-unit name="businessUnit"  class="selectpicker require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @if ($model->exists && $model->type  && $model->type->businessUnit)
                                                        @foreach (\App\ORM\BusinessUnit::orderBy('name', 'ASC')->get() as $bs)
                                                          <option {{ ($model->type->businessUnit->getKey() == $bs->getKey() ? 'selected' : '' ) }} value="{{{ $bs->getKey() }}}">{{{ $bs->name }}} </option>
                                                        @endforeach
                                                    @else
                                                        @foreach (\App\ORM\BusinessUnit::orderBy('name', 'ASC')->get() as $bs)
                                                          <option value="{{{ $bs->getKey() }}}">{{{ $bs->name }}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de servicio <strong class="require-mark">*</strong></label>
                                                <select service-type location-dep-ref name="service_type_id"  class="require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($serviceTypes as $serviceType)
                                                      <option business-unit="{{ $serviceType->businessUnit->getKey() }}" {{ ($model->service_type_id == $serviceType->getKey() ? 'selected' : '' ) }} value="{{{ $serviceType->getKey() }}}">{{{ $serviceType->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Pozo <strong class="require-mark">*</strong> </label>
                                                <select name="well_id" id="select-well"  data-live-search="true" class="selectpicker require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($wells as $well)
                                                      @if ($model->exists)
                                                        <option {{ ($model->well_id == $well->getKey() ? 'selected' : '' ) }} value="{{{ $well->getKey() }}}">{{{ $well->name }}}</option>
                                                      @else
                                                        <option {{ ($prewell == $well->getKey() ? 'selected' : '' ) }} value="{{{ $well->getKey() }}}">{{{ $well->name }}}</option>
                                                      @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de secci&oacute;n <strong class="require-mark">*</strong> </label>
                                                <select name="section_id"  data-live-search="true" class="selectpicker require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($sections as $section)
                                                      <option {{ ($model->section_id == $section->getKey() ? 'selected' : '' ) }} value="{{{ $section->getKey() }}}">{{{ $section->name }}}</option>
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
                         @if (!$model->exists)                            
                            @if( $user->can('createdraft', \App\ORM\Well::class ) )
                                <button type="submit"  name="action" value="createdraft"  class="btn btn-primary">
                                    Guardar Borrador
                                </button>  
                            @endif                             
                            @if( $user->can('createapproved', \App\ORM\Well::class ) )
                                <button type="submit"  name="action" value="createapproved"  class="btn btn-primary">
                                    Guardar y Aprobar
                                </button>  
                            @endif                      
                            @if( $user->can('createsendapprove', \App\ORM\Well::class ) )
                                <button type="button" assigned-modal class="btn btn-primary">
                                    Enviar a aprobaci&oacute;n
                                </button>  
                            @endif  
                        @else 

                            @if( $user->can('draft', $model ) )
                                <button type="submit"  name="action" value="draft"  class="btn btn-primary">
                                    Guardar Borrador
                                </button>
                            @endif 
                            @if( $user->can('fulledit', $model ) == true)
                                <button type="submit"  name="action" value="fulledit"  class="btn btn-primary">
                                    Guardar
                                </button>
                            @endif
                            @if( $user->can('approve', $model ) == true)
                                <button type="submit"  name="action" value="approve"  class="btn btn-primary">
                                    Guardar y Aprobar
                                </button>
                            @endif 
                            @if( $user->can('review', $model ) == true)
                                <button type="button" send-revision data-toggle="modal" data-target="#send-revision" class="btn btn-warning">
                                    Enviar revisi&oacute;n
                                </button>
                            @endif 
                            @if( $user->can('sendapprove', $model ) )
                                @if (!$model->assignedTo)
                                    <button type="button" assigned-modal class="btn btn-primary">
                                        Enviar a aprobaci&oacute;n
                                    </button> 
                                @else    
                                    <button type="submit" name="action" value="sendapprove" class="btn btn-primary">
                                        Enviar a aprobaci&oacute;n
                                    </button>
                                @endif
                            @endif
                            @if ($model->exists && $model->revisions && $model->revisions->count() > 0)
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#revisions-modal">
                                    Ver revisiones
                                </button>
                            @endif
                        @endif
                        <a href="{{{ url()->previous() }}}" class="btn btn-warning">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if( ( !$model->exists && $user->can('createsendapprove', $model) ) ||   ( !$model->assignedTo && $model->exists && $user->can('sendapprove', $model) ) ) 
            <div class="modal fade" id="select-assigned" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Enviar a aprobación</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="alert alert-info">
                                           Envia a un supervisor
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label >Supervisor  <strong class="require-mark">*</strong></label>
                                            <select id="select-supervisor" location-dep-ref location-list="supervisor" selectpicker data-live-search="true" name="assigned_to" class="required form-control">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="sumit" name="action" value="sendapprove" class="btn btn-primary">Enviar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        @endif
    </form>
</div>
@if ($model->exists && $model->revisions && $model->revisions->count() > 0 )
    <div class="modal fade" id="revisions-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Revisiones</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                @foreach ($model->revisions as $revision)
                                    <div class="alert alert-info">
                                       <strong>{{ $revision->created_at }} - {{ $revision->createdBy->name}}: </strong><br>
                                        {!! nl2br(e($revision->content)) !!}
                                    </div>
                                @endforeach                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                   
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endif


@if ( $model->exists && $user->can('review', $model ) )
<div class="modal fade" id="send-revision" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form form-revision method="post" action="{{ route('service-revision',['id'=>$model->getKey()]) }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Enviar revisi&oacute;n</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-info">
                                    Haz una descripci&oacute;n de los motivos de la revisi&oacute;n
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label >Contenido de revisi&oacute;n <strong class="require-mark">*</strong></label>
                                    <textarea name="content" class="required form-control"></textarea >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div alert></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="sumit"  class="btn btn-primary">Enviar</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif


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