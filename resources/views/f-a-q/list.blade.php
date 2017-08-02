@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<ol class="breadcrumb">
			  <li><a href="{{{ url('/') }}}">Inicio</a></li>
			  <li class="active">Ayuda</li>					  
			  <li class="active">Preguntas Frecuentes</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			@foreach ($list as $key => $model)
				<div class="panel-group">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#faq{{$model->getKey()}}" aria-expanded="true" aria-controls="faq{{$model->getKey()}}">
								{{ $key +1 }}. {{ $model->question }}
							</a>
							</h4>
						</div>
						<div id="faq{{$model->getKey()}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								{!! $model->answer !!}
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@stop()
