@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
    <form form-save id="save-well" action="{{{ ( !$model->exists  ? route('well.store') : route('well.update',['id'=>$model->getKey()]))  }}}" method="{{{ ( !$model->exists  ? 'POST' : 'PUT' )  }}}">
         <div class="row">
            <div class="col-xs-12">
                @include('wells.state-message', ['model'=>$model])
            </div>
        </div>
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
                                <div class="col-xs-12 ">                                   
                                    @if ($model->approved == 1 && !$user->can('updateapproved', $model))
                                        @include('wells.inner-show')
                                    @else
                                        @include('wells.inner-create')
                                    @endif                                    
                                </div>

                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Archivos adjuntos</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div id="list-files">
                                                <div class="row">
                                                    @foreach ($model->attachments as $key => $attachment)
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="well " data-old-attachment >
                                                                <div>
                                                                    <span class="label label-{{ $attachment->approved ? 'success' : 'warning' }}">{{ $attachment->approved ? 'Aprobado' : 'No aprobado' }}</span>
                                                                </div>
                                                                <a href="{{{ $model->routeToAttachment($attachment->id) }}}" data-url target="_blank">
                                                                    <div data-name="">{{{ $attachment->name }}}</div>
                                                                </a>
                                                                <input type="hidden" data-servername name="old_attachments[{{{ $key }}}][id]" value="{{{ $attachment->getKey() }}}">
                                                                <input data-removed type="hidden" data-servername name="old_attachments[{{{ $key }}}][deleted]" value="0">
                                                                @if($user->can('delete', $attachment))
                                                                    <button data-remove class="btn btn-danger btn-xs">Eliminar</button>                                                                   
                                                                @endif                                                               
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="col-xs-12">
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
                                <button type="submit" name="action" value="draft"  class="btn btn-primary">
                                    Guardar Borrador
                                </button>
                            @endif                             
                            @if( $user->can('approve', $model ) == true)                                
                                <button type="submit" name="action" value="approve"  class="btn btn-primary">
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
                            @if ($model->exists && $model->revisions &&  $model->revisions->count() > 0)
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
                                            @if ($model->approved == 1 && !$user->can('updateapproved', $model))                                               
                                                <label >Supervisor  <strong class="require-mark">*</strong></label>
                                                <select selectpicker data-live-search="true" name="assigned_to" class="required form-control">
                                                    @foreach ($supervisors as $element)
                                                        <option value="{{ $element->getKey()}}">{{ $element->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <label >Supervisor  <strong class="require-mark">*</strong></label>
                                                <select location-dep-ref location-list="supervisor" selectpicker data-live-search="true" name="assigned_to" class="required form-control">
                                                    
                                                </select>
                                            @endif    
                                            
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
    <div class="col-xs-12 col-sm-6">
        <div class="well">
            <a href="#" data-url target="_blank">
                <div data-name=""></div>
            </a>
            <div data-progress=""></div>
            <input type="hidden" data-servername name="attachments[{id}][file]">
            <input type="hidden" data-clientname name="attachments[{id}][name]">
            <button data-remove="" class="btn btn-danger btn-xs">Eliminar</button>
        </div>
    </div>
</div>
@stop
@section('footer')
    <script src="{{ asset('vendors/fileuploader/compiled.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.datawelluploader.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-select/dist/js/i18n/defaults-'.\Config::get('app.locale').'.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <script src="{{ asset('vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker/locales/bootstrap-datepicker.'.\Config::get('app.locale').'.min.js') }}"></script>

    <script src="{{ asset('js/scripts/entity.js') }}"></script>  
    <script src="{{ asset('js/scripts/jquery.sendajax.js?t='.time()) }}"></script>  
    <script src="{{ asset('js/scripts/well-controller.js?t='.time()) }}"></script>  
@stop