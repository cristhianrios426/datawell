@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
    <form form-save id="save-well" action="{{{ ( !$model->exists  ? route('well.store') : route('well.update',['id'=>$model->getKey()]))  }}}" method="{{{ ( !$model->exists  ? 'POST' : 'PUT' )  }}}">
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
                                                <input type="text" name="name" class="form-control required" value="{{{ $model->name }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en X  <strong class="require-mark">*</strong></label>
                                                <input type="text" name="x" class="number form-control required" value="{{{ $model->x }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en Y  <strong class="require-mark">*</strong></label>
                                                <input type="text" name="y" class="number form-control required" value="{{{ $model->y }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en Z</label>
                                                <input type="text" name="z" class="number form-control required" value="{{{ $model->z }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Sistema de coordenadas</label>
                                                <select name="ref_cor_sis_id" id="" class="form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($coorSystems as $sys)
                                                    <option {{ ($model->ref_cor_sis_id == $sys->getKey() ? 'selected' : '' ) }} value="{{{ $sys->getKey() }}}">{{{ $sys->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                             <div class="form-group">
                                                <label >Latitud</label>
                                                <input type="text" name="lat" class="form-control" value="{{{ $model->lat }}}">   
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label >Longitud</label>
                                                <input type="text" name="long" class="form-control" value="{{{ $model->long }}}">   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Profundidad TVD (ft)</label>
                                                <input type="number" name="profundidad_tvd" class="form-control" value="{{{ $model->z }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Profundidad MD (ft)</label>
                                                <input type="number" name="profundidad_md" class="form-control" value="{{{ $model->z }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Well kb elev (ft)</label>
                                                <input type="number" name="well_kb_elev" class="form-control" value="{{{ $model->z }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Rotaty elev (ft)</label>
                                                <input type="number" name="rotaty_elev" class="form-control" value="{{{ $model->z }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >Ubicaci&oacute;n  <strong class="require-mark">*</strong></label>
                                                <select selectpicker data-live-search="true" location-ref="loc" name="location_id" id="" class="required form-control">
                                                    @include('util.nested-tree-options', ['listModels'=>$locations, 'level'=>'', 'selected'=>$model->location_id])
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Cuenca  <strong class="require-mark">*</strong></label>
                                                <select location-list="cuenca" location-dep-ref name="cuenca_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($cuencas as $cuenca)
                                                    <option  {{ ($model->cuenca_id == $cuenca->getKey() ? 'selected' : '' ) }} value="{{{ $cuenca->getKey() }}}">{{{ $cuenca->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Campo  <strong class="require-mark">*</strong></label>
                                                <select location-list="camp" location-dep-ref name="camp_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($camps as $camp)
                                                    <option {{ ($model->camp_id == $camp->getKey() ? 'selected' : '' ) }} value="{{{ $camp->getKey() }}}">{{{ $camp->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Regi&oacute;n  <strong class="require-mark">*</strong></label>
                                                <select location-list="area"  location-dep-ref name="area_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($areas as $area)
                                                    <option  {{ ($model->area_id == $area->getKey() ? 'selected' : '' ) }} value="{{{ $area->getKey() }}}">{{{ $area->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Bloque  <strong class="require-mark">*</strong></label>
                                                <select location-list="block" location-dep-ref name="block_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($blocks as $block)
                                                        <option {{ ($model->block_id == $block->getKey() ? 'selected' : '' ) }} value="{{{ $block->getKey() }}}">{{{ $block->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de pozo  <strong class="require-mark">*</strong></label>
                                                <select name="well_type_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($types as $type)
                                                    <option {{ ($model->well_type_id == $type->getKey() ? 'selected' : '' ) }} value="{{{ $type->getKey() }}}">{{{ $type->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Desviación  <strong class="require-mark">*</strong></label>
                                                <select name="deviation_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($desviations as $desviation)
                                                        <option {{ ($model->deviation_id == $desviation->getKey() ? 'selected' : '' ) }} value="{{{ $desviation->getKey() }}}">{{{ $desviation->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                             <div class="form-group">
                                                <label >Operador  <strong class="require-mark">*</strong></label>
                                                <select name="operator_id" id="" class="required form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($operators as $operator)
                                                        <option {{ ($model->operator_id == $operator->getKey() ? 'selected' : '' ) }} value="{{{ $operator->getKey() }}}">{{{ $operator->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label >Fecha de perforaci&oacute;n <strong class="require-mark">*</strong></label>
                                                <input type="text" name="drilled_at" class="required form-control" value="{{{ $model->drilled_at }}}">   
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
                            @if( $user->can('createdraft' ) )
                                <button type="submit"  name="action" value="createdraft"  class="btn btn-primary">
                                    Guardar Borrador
                                </button>  
                            @endif                             
                            @if( $user->can('createapproved' ) )
                                <button type="submit"  name="action" value="approve"  class="btn btn-primary">
                                    Guardar y Aprobar
                                </button>  
                            @endif                      
                            @if( $user->can('createsendapprove' ) )
                                <button type="button" assigned-modal class="btn btn-primary">
                                    Enviar a aprobaci&oacute;n
                                </button>  
                            @endif  
                        @else 
                            @if( $user->can('update', $model ) && $model->state == 1)
                                <button type="submit"  name="action" value="draft"  class="btn btn-primary">
                                    Guardar Borrador
                                </button>  
                            @endif 
                            @if( $user->can('approve', $model ) == true)
                                <button type="submit"  name="action" value="approve"  class="btn btn-primary">
                                    Guardar y Aprobar
                                </button>
                            @endif                      
                            @if( $user->can('review', $model ) == true)
                                <button type="button" send-revision data-toggle="modal" data-target="#send-revision" class="btn btn-warning">
                                    Enviar a revisi&oacute;n
                                </button>
                            @endif 
                            @if( $user->can('sendapprove', $model ) )
                                <button type="button" assigned-modal class="btn btn-primary">
                                    Enviar a aprobaci&oacute;n
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
        @if( $model->exists && $user->can('sendapprove', $model) ) 
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
                                            <select location-dep-ref location-list="supervisor" selectpicker data-live-search="true" name="assigned_to" class="required form-control">
                                                
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

@if ( $model->exists && $user->can('review', $model ) )
<div class="modal fade" id="send-revision" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form form-revision method="post" action="{{ route('well-revision',['id'=>$model->getKey()]) }}">
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
    <script src="{{ asset('vendors/fileuploader/compiled.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.datawelluploader.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-select/dist/js/i18n/defaults-'.\Config::get('app.locale').'.js') }}"></script>

    <script src="{{ asset('js/scripts/entity.js') }}"></script>  
    <script src="{{ asset('js/scripts/jquery.sendajax.js?t='.time()) }}"></script>  
    <script src="{{ asset('js/scripts/well-controller.js?t='.time()) }}"></script>  
@stop