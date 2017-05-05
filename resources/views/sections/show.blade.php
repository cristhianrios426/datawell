<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Secci&oacute;n <strong>{{{ $model->name }}}</strong></h4>
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Nombre</label>
          <div>{{{ $model->name }}}</div>
        </div>
      </div>      
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
   
  </div>
</form>