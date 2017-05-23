@extends('layouts.front')
@section('content')
<div class="container">	
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="continer-fluid">
						<div class="row">
							<div class="col-xs-12">
								<h4>Ha ocurrido un error</h4>								
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<h2>{{ $exception->getMessage() }}</h2>
				</div>
			</div>
		</div>
	</div>
</div>
@stop()