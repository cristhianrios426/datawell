@extends('layouts.app')
@section('head')
  <meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <ol class="breadcrumb">
              <li><a href="{{{ url('/') }}}">Inicio</a></li>          
              <li><a href="{{ route('well.index') }}">Pozos</a></li>
              <li>{{ $model->name }}</li>
            </ol>
        </div>
    </div>
     <div class="row">
        <div class="col-xs-12">
            @include('wells.state-message', ['model'=>$model])
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 >{{{ $model->name }}}</h4>
                </div>
                <div class="panel-body">
                    <div class="fluid-container">
                        <div class="row">
                            <div class="col-xs-12">
                                @include('wells.inner-show')
                            </div>
                            <div class="col-xs-12">
                                <div class="fluid-container">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Archivos adjuntos</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($model->attachments as $attachment)
                                            <div class="col-xs-4">
                                                <div class="well">
                                                    <div>
                                                         <span class="label label-{{ $attachment->approved ? 'success' : 'warning' }}">{{ $attachment->approved ? 'Aprobado' : 'No aprobado' }}</span>
                                                    </div>
                                                    <a href="{{{ $model->routeToAttachment($attachment->getKey()) }}}" data-url target="_blank">
                                                        <div data-name=""> {{{ $attachment->name }}}</div>
                                                    </a>
                                                    <small><strong>Creado por:</strong> {{ $attachment->createdBy->name }} en {{ $attachment->created_at->format('Y-m-d') }} </small>
                                                    @if ($attachment->approved)
                                                        <br>
                                                        <small><strong>Aprobado por:</strong> {{ $attachment->approvedBy->name }} en {{ $attachment->approved_at->format('Y-m-d') }} </small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="panel-footer text-right">                        
                    <div class="btn-group">
                      <button class="btn btn-primary">Acciones</button>
                      <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        @can('update', $model)<li><a href="{{{ route($entityName.'.edit', ['id'=>$model->id]) }}}"  >Editar</a></li>@endcan
                        @can('update', $model)<li><a href="{{{ route('service.create',['well_id'=>$model->getKey()]) }}}"  >A&ntilde;adir servicio</a></li>@endcan
                        <li><a href="{{{ route($entityName.'.index') }}}"  >Ver listado</a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($model->services->count() > 0)
        <div class="row">
            <div class="col-xs-12">
                <h4>Servicios</h4>
            </div>
        </div>    
        <div class="row">
             @foreach ($model->services as $service)
                <div class="col-xs-12 col-sm-6">
                    @include('services.thumb',['model'=>$service])
                </div>
            @endforeach
        </div>
    @endif
    
</div>

<div class="modal fade" id="attachments-modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade " tabindex="-1" role="dialog" id="modal-model" aria-hidden="true" >
    <div class="modal-dialog ">
        <div class="modal-content" id="modal-content">            
        </div>
    </div>
</div>
@stop
@section('footer')
   
    <script src="{{ asset('js/scripts/entity.js') }}"></script>
    <script >
        (function(window, $){
            var crud = new window.CRUD('service');
            $('body').on('click', '*[data-remove]', function(){

                var $this = $(this);
                crud.entity.setId($this.data('remove'));
                crud.delete($('#modal-model .modal-content'))
                    .then(function(){
                        window.afterDeleteView();
                    });
            });
        })(window, jQuery);
    </script>
@stop
