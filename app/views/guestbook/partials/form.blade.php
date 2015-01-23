<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-generic" data-toggle="tab">{{ Lang::get('forms.tabs.generic') }}</a></li>
    </ul>
    @if($entity->id)
    {{ Form::open(['route' => ["manager.$routeSlug.update", $entity->id], 'method' => 'put', 'class' => 'form-vertical']) }}
    @else
    {{ Form::open(['route' => "manager.$routeSlug.store", 'class' => 'form-vertical']) }}
    @endif
        <div class="tab-content">
            <div class="tab-pane active" id="tab-generic">
                <div class="row">
                    @include('manager.partials.form_control', ['type' => 'textarea', 'field' => 'text'])
                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'is_visible', 'default' => 1])
                </div>
            </div>
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer')
        </div>
    {{ Form::close() }}
</div>
