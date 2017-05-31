
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{$name}}: Archivos adjuntos</h4>
        </div>
        <div class="modal-body">
            @forelse ($attachments as $attachment)
                <div class="row">
                    <div class="col-xs-12">
                        <div class="well">
                            <a href="{{{ $model->routeToAttachment($attachment->getKey()) }}}" data-url target="_blank">
                                <div data-name=""> {{{ $attachment->name }}}</div>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <h3>No hay archivos adjuntos</h3>
                </div>
            @endforelse
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div><!-- /.modal-content -->
