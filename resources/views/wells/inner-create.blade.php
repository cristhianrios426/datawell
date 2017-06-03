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
                @foreach ($deviations as $deviation)
                    <option {{ ($model->deviation_id == $deviation->getKey() ? 'selected' : '' ) }} value="{{{ $deviation->getKey() }}}">{{{ $deviation->name }}}</option>
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
            <input type="text" name="drilled_at" datepicker class="required form-control" value="{{{ $model->drilled_at ? $model->drilled_at->format('Y-m-d') : '' }}}">   
        </div>
    </div>
</div>