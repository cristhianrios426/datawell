<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label >Cliente<strong class="require-mark">*</strong></label>
            <select  name="client_id"  class="require form-control required">
                <option value="">Selecciona</option>
                @foreach (\App\ORM\Client::all()  as $client)
                  <option {{ $model->client && $model->client_id == $client->getKey() ? 'selected' : '' }} value="{{{ $client->getKey() }}}">{{{ $client->name }}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label >Unidad de negocios<strong class="require-mark">*</strong></label>
            <select business-unit name="businessUnit"  class="selectpicker require form-control required">
                <option value="">Selecciona</option>
                @if ($model->exists && $model->type  && $model->type->businessUnit)
                    @foreach (\App\ORM\BusinessUnit::orderBy('name', 'ASC')->get() as $bs)
                      <option {{ ($model->type->businessUnit->getKey() == $bs->getKey() ? 'selected' : '' ) }} value="{{{ $bs->getKey() }}}">{{{ $bs->name }}} </option>
                    @endforeach
                @else
                    @foreach (\App\ORM\BusinessUnit::orderBy('name', 'ASC')->get() as $bs)
                      <option value="{{{ $bs->getKey() }}}">{{{ $bs->name }}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>                                    
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label >Tipo de servicio <strong class="require-mark">*</strong></label>
            <select service-type location-dep-ref name="service_type_id"  class="require form-control required">
                <option value="">Selecciona</option>
                @foreach ($serviceTypes as $serviceType)
                  <option business-unit="{{ $serviceType->businessUnit->getKey() }}" {{ ($model->service_type_id == $serviceType->getKey() ? 'selected' : '' ) }} value="{{{ $serviceType->getKey() }}}">{{{ $serviceType->name }}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label >Pozo <strong class="require-mark">*</strong> </label>
            <select name="well_id" id="select-well"  data-live-search="true" class="selectpicker require form-control required">
                <option value="">Selecciona</option>
                @foreach ($wells as $well)
                  @if ($model->exists)
                    <option {{ ($model->well_id == $well->getKey() ? 'selected' : '' ) }} value="{{{ $well->getKey() }}}">{{{ $well->name }}}</option>
                  @else
                    <option {{ ($prewell == $well->getKey() ? 'selected' : '' ) }} value="{{{ $well->getKey() }}}">{{{ $well->name }}}</option>
                  @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label >Tipo de secci&oacute;n <strong class="require-mark">*</strong> </label>
            <select name="section_id"  data-live-search="true" class="selectpicker require form-control required">
                <option value="">Selecciona</option>
                @foreach ($sections as $section)
                  <option {{ ($model->section_id == $section->getKey() ? 'selected' : '' ) }} value="{{{ $section->getKey() }}}">{{{ $section->name }}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="form-group">
            <label >Fecha de terminaci&oacute;n <strong class="require-mark">*</strong> </label>
            <input type="text" name="ended_at" class="form-control required date" datepicker value="{{{ $model->ended_at }}}" >
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
         <div class="form-group">
            <label >Descripci&oacute;n</label>
            <textarea name="description" class="form-control" id="" >{{{ $model->description }}}</textarea>
        </div>
    </div>
</div>