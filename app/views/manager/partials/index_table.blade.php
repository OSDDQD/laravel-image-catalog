<div class="table-responsive">
    {{ Form::open(['route' => isset($destroyRoute) ? $destroyRoute : "manager.$routeSlug.destroy", 'method' => 'delete']) }}
    <table class="table table-bordered table-hover table-striped">
        <thead>
        <tr>
            <th>{{ Form::checkbox(null, 1, 0, ['id' => 'select-all-rows']) }}</th>
            <th>#</th>
            @foreach ($fields as $field)
                @if (is_array($field))
                    {{--*/ $field = $field[0] /*--}}
                @endif
                @if (strpos($field, '->'))
                    <?php list($related) = explode('->', $field); ?>
                    <th>{{ Lang::get("fields.$related") }}</th>
                @else
                    <th>{{ Lang::get("fields.$field") }}</th>
                @endif
            @endforeach
            <th>{{ Lang::get('buttons.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($entities as $i => $entity)
        @include ('manager.partials.index_tr', ['entity' => $entity])
        @endforeach
        </tbody>
    </table>
    {{ Form::submit(Lang::get('buttons.delete_selected'), ['class' => 'btn-large btn-danger btn']) }}
    {{ Form::close() }}
</div>
<script>
    $(function() {
        $('#select-all-rows').on('change', function(){
            $('.select-row').prop('checked', $(this).is(':checked'));
        });
    })
</script>
@if (method_exists($entities, 'links'))
<div class="text-center">
    {{ $entities->links() }}
</div>
@endif