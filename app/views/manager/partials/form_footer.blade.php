<div class="row">
    <div class="col-md-12">
        <div>
            @if (!isset($buttons) or in_array('save', $buttons))
            <input class="btn-large btn-primary btn" type="submit" value="{{ Lang::get('buttons.save') }}">
            @endif
            @if (!isset($buttons) or in_array('reset', $buttons))
            <input class="btn-large btn-default btn" type="reset" value="{{ Lang::get('buttons.reset') }}">
            @endif
            @if (!isset($buttons) or in_array('cancel', $buttons))
            <a class="btn-large btn-danger btn" href="{{ URL::Route("manager.$routeSlug.index", isset($indexRouteParams) ? $indexRouteParams : []) }}">{{ Lang::get('buttons.cancel') }}</a>
            @endif
            @if (!isset($buttons) or in_array('delete', $buttons))
                @if (isset($entity) and $entity->id)
                    <button id="delete-this" class="btn-large btn-danger btn pull-right" style="cursor: pointer;">{{ Lang::get('buttons.delete') }}</button>
                    <script>
                    $('#delete-this').on('click', function() {
                        $.post(
                            '{{ URL::Route(isset($destroyRoute) ? $destroyRoute : "manager.$routeSlug.destroy") }}',
                            { '_method': 'DELETE', 'id[0]': {{ $entity->id }} }
                        );
                        window.location.replace('{{ URL::Route("manager.$routeSlug.index", isset($indexRouteParams) ? $indexRouteParams : []) }}');
                        return false;
                    });
                    </script>
                @endif
            @endif
        </div>
    </div>
</div>