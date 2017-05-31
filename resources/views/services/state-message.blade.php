@if ($model->state == \App\ORM\Service::STATE_REVIEWING)
    <div class="alert alert-warning">
    	<h4>Este servicio está siendo revisado por un supervisor</h4>
    </div>
@endif
@if ($model->state == \App\ORM\Service::STATE_APPROVING)
	<div class="alert alert-warning">
    	<h4>Este servicio fue enviado al ingeniero  para su revisi&oacute;n</h4>
    </div>
@endif