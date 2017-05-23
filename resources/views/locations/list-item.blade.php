<div class="list-group-item" >
	<a  href="#children-{{$model->getKey()}}" data-toggle="collapse">
		<i class="glyphicon glyphicon-chevron-right"></i>{{$model->name}}	
	</a>
	<div class="btn-group">
		<button class="btn btn-xs btn-primary">Acciones</button>
		<button data-toggle="dropdown" class="btn btn-xs btn-primary dropdown-toggle"><span class="caret"></span></button>
		<ul class="dropdown-menu">
			@can('update', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-edit="{{{ $model->getKey() }}}">Editar</a></li> @endcan
			@can('delete', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-remove="{{{ $model->getKey() }}}">Eliminar</a></li> @endcan

			<li><a href="#" data-create data-toggle="modal" data-parent="{{{ $model->getKey() }}}" data-target="#modal-model">Crear hijo</a></li>
		</ul>
	</div>	
</div>
@if ($model->treeChildren->count() > 0)
	<div class="list-group collapse" id="children-{{$model->getKey()}}">
		@foreach ($model->treeChildren as $child)
			@include('locations.list-item', ['model'=>$child])
		@endforeach
	</div>
@else	
	<div class="list-group collapse" id="children-{{$model->getKey()}}">
		<a href="#" class="list-group-item" data-toggle="collapse">
			No hay registros
		</a>
	</div>
@endif										
