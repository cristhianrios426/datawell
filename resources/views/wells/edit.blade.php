<div class="container">
    <div class="row">
        <div class="col-xs-12">
            @if( $model->exists )
              <h4 class="modal-title">Nuevo {{{ $entityLabel }}}</h4>  
            @else
              <h4 class="modal-title">Editando {{{ $entityLabel }}} {{{ $model->name }}}</h4>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label >Nombre</label>
                <input type="text" name="name" class="form-control" value="{{{ $model->name }}}" placeholder="Email">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label >Coordenada en x</label>
                <input type="text" name="x" class="form-control" value="{{{ $model->x }}}" placeholder="Email">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label >Coordenada en y</label>
                <input type="text" name="y" class="form-control" value="{{{ $model->y }}}" placeholder="Email">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label >Coordenada en z</label>
                <input type="text" name="z" class="form-control" value="{{{ $model->z }}}" placeholder="Email">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label >Sistema de coordenadas</label>
                
            </div>
        </div>
    </div>
</div>
