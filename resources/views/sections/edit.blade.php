<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Editando <strong>{{{ $model->name }}}</strong> </h4>
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group">
          <label >Nombre</label>
          <input type="text" name="name" class="form-control" value="{{{ $model->name }}}" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div alert ></div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>
</form>