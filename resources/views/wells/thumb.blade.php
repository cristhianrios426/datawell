<div class="panel panel-info ">
	<div class="panel-heading"><h4>{{{ $model->name }}}</h4></div>
	<div class="panel-body">
		<ul class="list-group">
		  <li class="list-group-item"><strong>Estado de la informaci&oacute;n:</strong> 
		  	{{ $model->textState() }}						  	
		  </li>
		  <li class="list-group-item"><strong>Tipo de pozo:</strong> {{{ $model->type ? $model->type->name : '' }}} </li>
		  <li class="list-group-item"><strong>Ubicación:</strong> {{{ $model->location ? $model->location->fullName() : '' }}} </li>
		  <li class="list-group-item"><strong>Operador:</strong> {{{ $model->operator ? $model->operator->name : '' }}} </li>
		  <li class="list-group-item"><strong>Servicios en las secciones:</strong> {{{ implode(', ', $model->sectionsNames()) }}} </li>
		  <li class="list-group-item"><strong>Tipos de servicio:</strong> {{{ implode(', ', $model->serviceTypesNames()) }}} </li>
		  <li class="list-group-item"><strong>Regi&oacute;n:</strong> {{{ $model->area ? $model->area->name : '' }}} </li>
		  <li class="list-group-item"><strong>Profundidad TVD (ft):</strong> {{{ $model->profundidad_tvd }}} </li>
		</ul>
	</div>
	<div class="panel-footer text-right">							
		<div class="btn-group">
		  <button class="btn btn-primary">Acciones</button>
		  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
		  <ul class="dropdown-menu">
				@can('view', $model)<li><a href="{{{ route($entityName.'.show', ['id'=>$model->id]) }}}"  >Ver detalle</a></li>@endcan
			 	@can('update', $model)<li><a href="{{{ route('service.create',['well_id'=>$model->getKey()]) }}}"  >A&ntilde;adir servicio</a></li>@endcan
				@can('update', $model)<li><a href="{{{ route($entityName.'.edit', ['id'=>$model->id]) }}}"  >Editar</a></li>@endcan
				@can('delete', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-remove="{{{ $model->getKey() }}}">Eliminar</a></li> @endcan
		  </ul>
		</div>
	</div>
</div>