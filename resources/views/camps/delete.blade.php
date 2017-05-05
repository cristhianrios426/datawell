<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Eliminar {{{ $entityLabel }}}</h4>
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12">
        <div class="alert alert-warning">
          <h4>&iquest;Est&aacute; seguro de eliminar el {{{ $entityLabel }}} <i><strong>"{{ $model->name }}"</strong></i>? Los cambios ser&aacute;n permanentes e irreversibles.</h2></h4>
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
    <button type="button" class="btn btn-success" data-dismiss="modal">No estoy seguro</button>
    <button type="submit" class="btn btn-danger">S&iacute;, eliminar</button>
  </div>
</form>