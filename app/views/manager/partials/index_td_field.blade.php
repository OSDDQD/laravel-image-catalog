@if (substr($field, 0, 3) == 'is_')
    @if ($entity->$field)
        <div class="label label-success">{{ Lang::get('forms.labels.yes') }}</div>
    @else
        <div class="label label-danger">{{ Lang::get('forms.labels.no') }}</div>
    @endif
@elseif (strpos($field, '->'))
    <?php list($related, $field) = explode('->', $field); ?>
    @foreach ($entity->$related as $rel)
        @if (isset($langTranslations) and array_key_exists($related, $langTranslations))
            {{ Lang::get($langTranslations[$related].'.'.$rel->$field) }}<br>
        @else
            @if (isset($options) and isset($options['sanitize']) and $options['sanitize'])
                {{{ $rel->$field }}}<br>
            @else
                {{ $rel->$field }}<br>
            @endif
        @endif
    @endforeach
@else
    @if (isset($langTranslations) and array_key_exists($field, $langTranslations))
        {{ Lang::get($langTranslations[$field].'.'.$entity->$field) }}
    @else
        @if (isset($options) and isset($options['sanitize']) and $options['sanitize'])
            {{{ $entity->$field }}}
        @else
            {{ $entity->$field }}
        @endif
    @endif
@endif