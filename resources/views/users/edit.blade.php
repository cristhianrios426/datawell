<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">
    @if ($model->exists)
      Editando {{{ $entityLabel }}} {{{ $model->name }}}
    @else
      Creando {{{ $entityLabel }}}
    @endif
  </h4>
</div>
<form action="" form-send>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12">
        <h5>Datos principales</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="form-group">
          <label >Nombre Completo</label>
          <input type="text" name="name" class="required form-control" value="{{{ $model->name }}}" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Email</label>
          <input type="text" name="email" class="required email form-control" value="{{{ $model->email }}}" >
        </div>
      </div>
      <div class="col-xs-12  col-sm-6">
        <div class="form-group">
          <label >Estado</label>
          <select name="state" class="required form-control" >
            <option value="">Selecciona</option>
            <option {{{ ( $model->state  == \App\ORM\User::ACTIVE ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::ACTIVE }}}">Activo</option>
            <option {{{ ( $model->state  == \App\ORM\User::INACTIVE ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::INACTIVE }}}">Inactivo</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Rol</label>
          <select name="role_id" class="required form-control" >
            <option value="">Selecciona</option>
            <option {{{ ( $model->role_id  == \App\ORM\User::ROLE_ADMIN ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::ROLE_ADMIN }}}">Administrador</option>
            <option {{{ ( $model->role_id  == \App\ORM\User::ROLE_ENG ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::ROLE_ENG }}}">Ingeniero</option>
            <option {{{ ( $model->role_id  == \App\ORM\User::ROLE_SUPER ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::ROLE_SUPER }}}">Supervisor</option>
            <option {{{ ( $model->role_id  == \App\ORM\User::ROLE_CLIENT ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::ROLE_CLIENT }}}">Cliente</option>
            <option {{{ ( $model->role_id  == \App\ORM\User::ROLE_MANAGER ? 'selected' : '' ) }}} value="{{{ \App\ORM\User::ROLE_MANAGER }}}">Gerente</option>
          </select>
        </div>
      </div>
      <div class="col-xs-12  col-sm-6">
        <div class="form-group">
         
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h5>Datos personales</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Tipo de identificaci&oacute;n</label>
          <select name="ide_type" class="required form-control" >
            <option value="">Selecciona</option>
            @foreach ($types as $type)
              <option {{{ ($type->getKey() == $model->ide_type ? 'selected' : '' ) }}} value="{{{ $type->getKey() }}}">{{{ $type->name }}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >N&uacute;mero de identificaci&oacute;n</label>
          <input type="text" name="ide" class="required form-control" value="{{{ $model->ide }}}" placeholder="">
        </div>
      </div>
    </div>    
    <div class="row">      
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Tel&eacute;fono fijo</label>
          <input type="text" name="phone" class="form-control" value="{{{ $model->phone }}}" >
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Tel&eacute;fono de celular</label>
          <input type="text" name="cell" class="form-control" value="{{{ $model->cell }}}" placeholder="">
        </div>
      </div> 
    </div>
    <div class="row">      
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Direcci&oacute;n</label>
          <input type="text" name="address" class="form-control" value="{{{ $model->address }}}" placeholder="">
        </div>
      </div>      
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h5>Datos de contacto de empresa</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Tel&eacute;fono fijo de empresa</label>
          <input type="text" name="job_phone" class="form-control" value="{{{ $model->job_phone }}}" placeholder="">
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Tel&eacute;fono celular de empresa</label>
          <input type="text" name="job_cell" class="form-control" value="{{{ $model->job_cell }}}" placeholder="">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label >Direcci&oacute;n de empresa</label>
          <input type="text" name="job_address" class="form-control" value="{{{ $model->job_address }}}" placeholder="">
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