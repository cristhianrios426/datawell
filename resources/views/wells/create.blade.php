@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
    <form action="{{{ ( !$model->exists  ? route('well.store') : route('well.update',['id'=>$model->getKey()]))  }}}" method="{{{ ( !$model->exists  ? 'POST' : 'PUT' )  }}}">
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
                                                <label >Coordenada en X  <strong class="require-mark">*</strong></label>
                                                <input type="text" name="x" class="require form-control required" value="{{{ $model->x }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en Y  <strong class="require-mark">*</strong></label>
                                                <input type="text" name="y" class="require form-control required" value="{{{ $model->y }}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en Z</label>
                                                <input type="text" name="z" class="require form-control required" value="{{{ $model->z }}}" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Sistema de coordenadas</label>
                                                <select name="id_ref_cor_sis" id="" class="require form-control required">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($coorSystems as $sys)
                                                    <option {{ ($model->id_ref_cor_sis == $sys->getKey() ? 'selected' : '' ) }} value="{{{ $sys->getKey() }}}">{{{ $sys->name }}}</option>
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
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Cuenca  <strong class="require-mark">*</strong></label>
                                                <select name="id_cuenca" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($cuencas as $cuenca)
                                                    <option  {{ ($model->id_cuenca == $cuenca->getKey() ? 'selected' : '' ) }} value="{{{ $cuenca->getKey() }}}">{{{ $cuenca->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Campo  <strong class="require-mark">*</strong></label>
                                                <select name="id_camp" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($camps as $camp)
                                                    <option {{ ($model->id_camp == $camp->getKey() ? 'selected' : '' ) }} value="{{{ $camp->getKey() }}}">{{{ $camp->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Regi&oacute;n  <strong class="require-mark">*</strong></label>
                                                <select name="id_area" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($areas as $area)
                                                    <option {{ ($model->id_area == $area->getKey() ? 'selected' : '' ) }} value="{{{ $area->getKey() }}}">{{{ $area->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Bloque  <strong class="require-mark">*</strong></label>
                                                <select name="id_block" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($blocks as $block)
                                                        <option {{ ($model->id_block == $block->getKey() ? 'selected' : '' ) }} value="{{{ $block->getKey() }}}">{{{ $block->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de pozo  <strong class="require-mark">*</strong></label>
                                                <select name="id_well_type" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($types as $type)
                                                    <option {{ ($model->id_well_type == $type->getKey() ? 'selected' : '' ) }} value="{{{ $type->getKey() }}}">{{{ $type->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Desviación  <strong class="require-mark">*</strong></label>
                                                <select name="id_deviation" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($desviations as $desviation)
                                                        <option {{ ($model->id_deviation == $desviation->getKey() ? 'selected' : '' ) }} value="{{{ $desviation->getKey() }}}">{{{ $desviation->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                             <div class="form-group">
                                                <label >Operador  <strong class="require-mark">*</strong></label>
                                                <select name="id_operator" id="" class="require form-control">
                                                    <option value="">Selecciona</option>
                                                    @foreach ($operators as $operator)
                                                        <option {{ ($model->id_operator == $operator->getKey() ? 'selected' : '' ) }} value="{{{ $operator->getKey() }}}">{{{ $operator->name }}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label >Fecha de perforaci&oacute;n <strong class="require-mark">*</strong></label>
                                                <input type="text" name="drilled_at" class="require form-control" value="{{{ $model->drilled_at }}}">   
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
    <script src="{{ asset('vendors/fileuploader/compiled.js') }}"></script>
    <script src="{{ asset('js/scripts/jquery.datawelluploader.js') }}"></script>
    <script src="{{ asset('js/scripts/entity.js') }}"></script>  
    <script src="{{ asset('js/scripts/jquery.sendajax.js?t='.time()) }}"></script>  
    <script src="{{ asset('js/scripts/well-controller.js?t='.time()) }}"></script>  
@stop