<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-generic" data-toggle="tab">{{ Lang::get('forms.tabs.generic') }}</a></li>
        <li><a href="#tab-top-slider" data-toggle="tab">{{ Lang::get('forms.tabs.slider') }}</a></li>
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
            <div class="tab-pane" id="tab-top-slider">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ Lang::get('manager.slider.image') }}</th>
                                    <th>{{ Lang::get('manager.slider.file_upload') }}</th>
                                    <th>{{ Lang::get('manager.slider.delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < 5; $i++)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if (isset($topSliderData[$i]) and $topSliderData[$i])
                                            <img src="{{ \URL::Route('preview.managed', ['object' => 'slider', 'mode' => 'managertable', 'format' => 'jpg', 'file' => $topSliderData[$i]->getUploadedFilename('jpg')]) }}" alt="" />
                                        @else
                                            {{ Lang::get('manager.messages.no_image') }}
                                        @endif
                                    </td>
                                    <td>{{ Form::file("top_slider[$i]", [], ['class' => 'form-control']) }}</td>
                                    <td>{{ Form::checkbox("top_slider_delete[$i]", 1, 0) }}</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @foreach (Config::get('app.locales') as $i => $locale)
                <div class="tab-pane" id="tab-{{ $locale }}">
                    <div class="row">
                        @foreach($localizedFields[$locale] as $localizedField)
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->first($localizedField->name) ? ' has-error' : null }}">
                                    {{ Form::label($locale.'['.$localizedField->name.']', Lang::get("settings.$localizedField->name._title"), ['class' => 'control-label']) }}
                                    {{ Form::text($locale.'['.$localizedField->name.']', $localizedField->value, ['class' => 'form-control']) }}
                                    {{ $errors->first($localizedField->name, '<span class="help-block has-error">:message</span>') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer', ['buttons' => ['save', 'reset']])
        </div>
    {{ Form::close() }}
</div>
