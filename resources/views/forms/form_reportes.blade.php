<div class="item form-group">
 <div class="col-md-2 col-sm-2 col-xs-12">
    {!!Html::decode(Form::label('entities_id', 'Entidad<span class="required">  </span>', ['class' => 'control-label']))!!}
     </div>
    <div class="col-md-10 col-sm-10 col-xs-12">
      <select id="recursives" name="entities_id">
          @foreach($entidad as $option)
            <option value="{{$option->id}}"  @if(($option->entities_id)>-1) data-parent="{{$option->entities_id}}" @endif>{{$option->name}}</option>
            @endforeach
        </select>
        <div class="help-block with-errors">
        </div>
    </div>
</div>


<div class="item form-group">
  <div class="col-md-2 col-sm-2 col-xs-12">
    {!!Html::decode(Form::label('realname', 'Nombre<span class="required"> * </span>', ['class' => 'control-label']))!!}
     </div>
    <div class="col-md-10 col-sm-10 col-xs-12">
        {!!Form::text('realname', null,['required', 'class'=>'form-control'])!!}
        <div class="help-block with-errors">
        </div>
    </div>
</div>

<div class="item form-group">
 <div class="col-md-2 col-sm-2 col-xs-12">
    {!!Html::decode(Form::label('profiles_id', 'Tipo de archivo<span class="required"> * </span>', ['class' => 'control-label']))!!}
     </div>
    <div class="col-md-10 col-sm-10 col-xs-12">
     <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-users"></i></div>
        {!! Form::select('tipo', [""=>"Seleccione una opción"]+config('domains.Files'), null, ['required','class'=>'form-control']) !!}
        </div>
        <div class="help-block with-errors">
        </div>
    </div>
</div>