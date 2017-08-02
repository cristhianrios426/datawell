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
          <label >Nombre</label>
          <input type="text" name="name" class="form-control" value="{{ $model->name }}" >
        </div>
      </div>      
    </div>
    <div class="row">
      <div class=" col-xs-12">
        <div class="form-group">
          <label >Roles de usuario</label>
          <select name="role_id" class="form-control">
            <option  {{ $model->role_id == \App\ORM\User::ROLE_SUPERADMIN ? 'selected' : '' }} value="{{ \App\ORM\User::ROLE_SUPERADMIN }}">Super administrador</option>
            <option  {{ $model->role_id == \App\ORM\User::ROLE_ADMIN ? 'selected' : '' }} value="{{ \App\ORM\User::ROLE_ADMIN }}">Administrador</option>
            <option  {{ $model->role_id == \App\ORM\User::ROLE_ENG ? 'selected' : '' }} value="{{ \App\ORM\User::ROLE_ENG }}">Ingeniero</option>
            <option  {{ $model->role_id == \App\ORM\User::ROLE_SUPER ? 'selected' : '' }} value="{{ \App\ORM\User::ROLE_SUPER }}">Supervisor</option>
            <option  {{ $model->role_id == \App\ORM\User::ROLE_CLIENT ? 'selected' : '' }} value="{{ \App\ORM\User::ROLE_CLIENT }}">Cliente</option>
            <option  {{ $model->role_id == \App\ORM\User::ROLE_MANAGER ? 'selected' : '' }} value="{{ \App\ORM\User::ROLE_MANAGER }}">Gerente</option>
          </select>
        </div>
      </div>      
    </div>
    <div class="row">
      <div class=" col-xs-12">
        <div class="form-group">
          <label >Archivo adjunto</label>
          <div class="btn btn-info relative form-control" data-uploader >
              <span><i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;<span class="text-uploader">{{ ( !$model->exists || $model->file == '' ? 'Adjuntar archivo' :  $model->client_file ) }}</span></span>
              <input type="file" name="files" class="hidden-action">
              <input type="hidden" class="hidden-file" name="file" value="{{ $model->file  }}">
              <input type="hidden" class="hidden-client-file" name="client_file" value="{{ $model->client_file  }}">
          </div>
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