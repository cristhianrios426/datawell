<div class="panel panel-default">
    <div class="panel-heading">
        <h5>{{$model->type->name}}</h5>
    </div>
    <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>Estado de la informaci&oacute;n:</strong> 
            {{ $model->textState() }}               
          </li>
          <li class="list-group-item"><strong>Fecha de inicio: </strong> {{{ $model->started_at->format('Y-m-d') }}} </li>
          <li class="list-group-item"><strong>Fecha de terminaci&oacute;n: </strong> {{{ $model->ended_at->format('Y-m-d') }}} </li>          
          <li class="list-group-item"><strong>Cliente:</strong> {{{ $model->client ? $model->client->name : '' }}} </li>
          <li class="list-group-item"><strong>Tipo de servicio: </strong> {{{ $model->type ? $model->type->name : '' }}} </li>
          <li class="list-group-item"><strong>Tipo de secci&oacute;n: </strong> {{{ $model->section ? $model->section->name : '' }}} </li>
          
        </ul>
    </div>
    <div class="panel-footer text-right">                        
        <div class="btn-group">
          <button class="btn btn-primary">Acciones</button>
          <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
          <ul class="dropdown-menu">
            @can('update', $model)<li><a href="{{{ route('service.edit', ['id'=>$model->id]) }}}"  >Editar</a></li>@endcan
            <li><a href="{{{ route('service.show', ['id'=>$model->id]) }}}"  >Ver detalle</a></li>
            <li><a href="" data-href="{{{ route('service.attachments', ['id'=>$model->id]) }}}" data-toggle="modal" data-target="#attachments-modal" >Ver archivos</a></li>
            @can('delete', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-remove="{{{ $model->getKey() }}}">Eliminar</a></li> @endcan
          </ul>
        </div>
    </div>
</div>