<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-settings" data-toggle="tab">{{ Lang::get('forms.tabs.settings') }}</a></li>
        @foreach (Config::get('app.locales') as $i => $locale)
        <li><a href="#tab-{{ $locale }}" data-toggle="tab">{{ Lang::get("languages.$locale") }}</a></li>
        @endforeach
    </ul>
    @if($entity->id)
    {{ Form::open(['route' => ["manager.$routeSlug.update", $entity->id], 'method' => 'put', 'files' => true, 'class' => 'form-vertical']) }}
    @else
    {{ Form::open(['route' => "manager.$routeSlug.store", 'files' => true, 'class' => 'form-vertical']) }}
    @endif
        <div class="tab-content">
            <div class="tab-pane active" id="tab-settings">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"{{ $errors->first('type') ? ' has-error' : null }}>
                            {{ Form::label('type', Lang::get('fields.type'), ['class' => 'control-label']) }}
                            {{ Form::select('type',
                                Material::getPossibleTypes(true),
                                $entity->type, ['class' => 'form-control']) }}
                            {{ $errors->first('type', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    {{ Form::hidden('is_visible', 0) }}
                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'is_visible', 'default' => 1])
                    @include('manager.partials.form_control', ['type' => 'file', 'field' => 'image'])
                </div>
            </div>
            @foreach (Config::get('app.locales') as $i => $locale)
            <div class="tab-pane" id="tab-{{ $locale }}">
                <div class="row">
                    @include('manager.partials.form_control_translated', ['type' => 'text', 'field' => 'title', 'locale' => $locale])
                    @include('manager.partials.form_control_translated', ['type' => 'textarea', 'field' => 'text', 'locale' => $locale, 'controlClass' => 'tinymce'])
                </div>
            </div>
            @endforeach
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer')
        </div>
    {{ Form::close() }}
</div>
