<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  @if (!$model->exists)
    <h4 class="modal-title">Nuevo {{{ $entityLabel }}}</h4>
  @else
    <h4 class="modal-title">Editando {{{ $entityLabel }}}</i> </h4>
  @endif
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class=" col-xs-12">
        <div class="form-group">
          <label >Pregunta</label>
          <input type="text" name="question" class="form-control" value="{{ $model->question }}" >
        </div>
      </div>      
    </div>
    <div class="row">
      <div class=" col-xs-12">
        <div class="form-group">
          <label >Respuesta</label>
          <textarea type="text" name="answer" class="form-control"  >{{ $model->answer }}</textarea>
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