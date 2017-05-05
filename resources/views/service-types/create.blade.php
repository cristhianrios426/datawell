<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Nuevo {{{ $entityLabel }}}</h4>
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6">
        <div class="form-group"  container-new-unit style="display: none">
          <label >Nueva unidad de negocios</label>
          <div class="input-group">
            <input class="form-control" id="exampleInputAmount" placeholder="Nombre de unidad negocio"> 
            <div title="Mostrar lista" cancel-new-unit class="input-group-addon btn btn-danger"><i class="glyphicon glyphicon-remove"></i></div> 
          </div>
        </div>
        <div class="form-group" container-select-unit  >
          <label >Unidad de negocios</label>
          <select class="form-control" select-unit name="" id="">
            <option value="">Selecciona</option>
            <option value="new">Crear nueva unidad de negocios</option>
            @foreach ($businessUnits as $businessUnit)
              <option value="{{ $businessUnit->getKey() }}">{{ $businessUnit->name }}</option>
            @endforeach
          </select>
        </div>
      </div>  
      <div class="col-xs-6">
        <div class="form-group">
          <label >Nombre</label>
          <input type="text" name="name" class="form-control" value="" >
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