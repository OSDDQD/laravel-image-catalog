<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-generic" data-toggle="tab">{{ Lang::get('forms.tabs.generic') }}</a></li>
        @foreach (Config::get('app.locales') as $i => $locale)
        <li><a href="#tab-{{ $locale }}" data-toggle="tab">{{ Lang::get("languages.$locale") }}</a></li>
        @endforeach
    </ul>
    {{ Form::open(['route' => ["manager.$routeSlug.update"], 'method' => 'put', 'files' => true, 'class' => 'form-vertical']) }}
        <div class="tab-content">
            <div class="tab-pane active" id="tab-generic">
                <div class="row">
                    @foreach($textFields as $textField)
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->first($textField->name) ? ' has-error' : null }}">
                                {{ Form::label($textField->name, Lang::get("settings.$textField->name._title"), ['class' => 'control-label']) }}
                                {{ Form::text($textField->name, $textField->value, ['class' => 'form-control']) }}
                                {{ $errors->first($textField->name, '<span class="help-block has-error">:message</span>') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @foreach (Config::get('app.locales') as $i => $locale)
                <div class="tab-pane" id="tab-{{ $locale }}">
                    <div class="row">
                        @if (isset($localizedFields[$locale]))
                            @foreach($localizedFields[$locale] as $localizedField)
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->first($localizedField->name) ? ' has-error' : null }}">
                                        {{ Form::label($locale.'['.$localizedField->name.']', Lang::get("settings.$localizedField->name._title"), ['class' => 'control-label']) }}
                                        {{ Form::text($locale.'['.$localizedField->name.']', $localizedField->value, ['class' => 'form-control']) }}
                                        {{ $errors->first($localizedField->name, '<span class="help-block has-error">:message</span>') }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer', ['buttons' => ['save', 'reset']])
        </div>
    {{ Form::close() }}
</div>
