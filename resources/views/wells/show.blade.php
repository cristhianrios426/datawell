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
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label >Nombre</label>
                                                <div class="form-control"  >{{{ $model->name }}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en x</label>
                                                <div class="form-control"  >{{{ $model->x }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en y</label>
                                                <div class="form-control"  >{{{ $model->y }}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Coordenada en z</label>
                                                <div class="form-control"  >{{{ $model->z }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Sistema de coordenadas</label>
                                                <div class="form-control"  >{{{ ( $model->coorSys ?  $model->coorSys->name : '--') }}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                             <div class="form-group">
                                                <label >Latitud</label>
                                                <div class="form-control"  >{{{ $model->lat }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label >Longitud</label>
                                                <div class="form-control"  >{{{ $model->long }}}</div>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >profundidad tvd</label>
                                                <div class="form-control"  >{{{ $model->profundidad_tvd }}}</div> 
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >profundidad md</label>
                                                <div class="form-control"  >{{{ $model->profundidad_md }}}</div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >well_kb_elev</label>
                                                <div class="form-control"  >{{{ $model->well_kb_elev }}}</div>                                                 
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >rotaty_elev</label>
                                                <div class="form-control"  >{{{ $model->rotaty_elev }}}</div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Cuenca</label>
                                                <div class="form-control"  >{{{ ( $model->cuenca ?  $model->cuenca->name : '--') }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Campo</label>
                                                <div class="form-control"  >{{{ ( $model->camp ?  $model->camp->name : '--') }}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Regi&oacute;n</label>
                                                <div class="form-control"  >{{{ ( $model->area ?  $model->area->name : '--') }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Bloque</label>
                                                <div class="form-control"  >{{{ ( $model->block ?  $model->block->name : '--') }}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Tipo de pozo</label>
                                                <div class="form-control"  >{{{ ( $model->type ?  $model->type->name : '--') }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label >Desviaci&oacute;n</label>
                                                <div class="form-control"  >{{{ ( $model->deviation ?  $model->deviation->name : '--') }}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                             <div class="form-group">
                                                <label >Operador</label>
                                                <div class="form-control"  >{{{ ( $model->operator ?  $model->operator->name : '--') }}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label >Fecha de excavaci&oacute;n</label>
                                                <div class="form-control"  >{{{ ( $model->drilled_at ) }}}</div>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="{{ asset('js/scripts/jquery.sendajax.js') }}"></script>  
    <script src="{{ asset('js/scripts/well-controller.js') }}"></script>  
@stop