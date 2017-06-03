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
            <label >Fecha de perforaci&oacute;n</label>
            <div class="form-control"  >{{{ ( $model->drilled_at ? $model->drilled_at->format('Y-m-d') : '' ) }}}</div>
        </div>
    </div>
</div>