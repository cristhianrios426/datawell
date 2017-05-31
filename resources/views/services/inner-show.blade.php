<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            <label >Cliente  <strong class="require-mark">*</strong></label>
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