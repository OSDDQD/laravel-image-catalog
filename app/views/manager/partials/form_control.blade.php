@if ($type != 'hidden')
<div class="col-md-12">
    <div class="form-group{{ $errors->first($field) ? ' has-error' : null }}">
        {{ Form::label($field, (isset($label) ? $label : Lang::get("fields.$field")), ['class' => 'control-label']) }}
        @endif
        @if ($type == 'checkbox')
            {{ Form::hidden($field, 0) }}
            {{ Form::checkbox($field, (isset($value) ? $value : 1), ($entity->id ? $entity->$field : (isset($default) ? $default : 1))) }}
        @elseif ($type == 'file')
            {{ Form::$type($field, array_merge((isset($attributes) ? $attributes : []), ['class' => 'form-control'])) }}
        @else
            {{ Form::$type($field, $entity->$field, array_merge((isset($attributes) ? $attributes : []), ['class' => 'form-control'])) }}
        @endif
        {{ $errors->first($field, '<span class="help-block has-error">:message</span>') }}
        @if ($type != 'hidden')
    </div>
</div>
@endif