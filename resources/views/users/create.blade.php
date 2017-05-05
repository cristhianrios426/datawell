<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Nuevo usuario</h4>
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Nombre</label>
          <input type="text" name="name" class="form-control" value="" placeholder="Email">
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Email</label>
          <input type="text" name="email" class="form-control" value="" placeholder="Email">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Tipo de identificaci&oacute;n</label>
          <select name="ide_type" class="form-control" >
            <option value="">Selecciona</option>
            @foreach ($types as $type)
              <option value="{{{ $type->getKey() }}}">{{{ $type->name }}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >N&uacute;mero de identificaci&oacute;n</label>
          <input type="text" name="ide" class="form-control" value="" placeholder="">
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