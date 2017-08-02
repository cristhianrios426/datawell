@if ($model->approving())
    <div class="alert alert-warning">
    	<h4>Aprobaci&oacute;n pendiente {{  $model->assignedTo ? ' por supervisor '.$model->assignedTo->name : '' }}</h4>
    </div>
@endif
@if ($model->draft == 1)
    <div class="alert alert-warning">
    	<h4>Borrador {{  $model->createdBy ? ' creado por '.$model->createdBy->name : '' }}</h4>
    </div>
@endif
@if ($model->reviewing())
	<div class="alert alert-warning">
    	<h4>Revisión pendiente {{  $model->sentBy ? 'por '.$model->sentBy->name : ''  }}</h4>
    </div>
@endif
