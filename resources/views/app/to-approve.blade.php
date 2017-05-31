@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3>Pozos pendientes por aprobar</h3>
            </div>
        </div>
        <div class="row">
            @forelse ($wells as $well)
                <div class="col-xs-12 col-sm-6">
                    @include('wells.thumb', ['model'=>$well, 'entityName'=>'well'])
                </div>
            @empty
                <div class="alert alert-info">
                  No hay pozos pendientes por aprobar  
                </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3>Servicios pendientes por aprobar</h3>
            </div>
        </div>
        <div class="row">
            @forelse ($services as $service)
                <div class="col-xs-12 col-sm-6">
                    @include('services.thumb', ['model'=>$service, 'entityName'=>'service'])
                </div>
            @empty
                <div class="alert alert-info">
                  No hay servicios pendientes por aprobar  
                </div>
            @endforelse
        </div>
    </div>
@stop
