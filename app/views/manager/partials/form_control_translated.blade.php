<div class="col-md-12">
    <div class="form-group{{ $errors->first($field) ? ' has-error' : null }}">
        {{ Form::label($locale.'['.$field.']', (isset($label) ? $label : Lang::get("fields.$field")), ['class' => 'control-label' . (isset($labelClass) ? ' '.$labelClass : null )]) }}
        {{ Form::$type($locale.'['.$field.']', $entity->translate($locale)->$field, ['class' => 'form-control' . (isset($controlClass) ? ' '.$controlClass : null )]) }}
        {{ $errors->first($field, '<span class="help-block has-error">:message</span>') }}
    </div>
</div>