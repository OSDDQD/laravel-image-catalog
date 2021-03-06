<?php $maxPosition = \Catalog\Category::count() + ($entity->id ? 0 : 1); ?>
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
                    @include('manager.partials.form_control', [
                        'type' => 'selectEnhanced',
                        'field' => 'position',
                        'selected' => ($entity->id ? $entity->position : $maxPosition),
                        'list' => array_combine(range(1, $maxPosition), range(1, $maxPosition))
                    ])
                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'is_visible', 'default' => 1])
                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'is_intro', 'default' => 0])
                    @include('manager.partials.form_control', ['type' => 'file', 'field' => 'image'])
                    @if (isset($entity->image) and $entity->image)
                        <div class="col-md-12">
                            <div class="form-group">
                                <img src="{{ \URL::Route('preview.managed', ['object' => 'category', 'mode' => 'preview', 'format' => 'jpg', 'file' => $entity->image]) }}" alt="" />
                            </div>
                        </div>
                        @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'image_delete', 'default' => 0])
                    @endif
                    @include('manager.partials.form_control', ['type' => 'file', 'field' => 'image_desc'])
                    @if (isset($entity->image_desc) and $entity->image_desc)
                        <div class="col-md-12">
                            <div class="form-group">
                                <img src="{{ \URL::Route('preview.managed', ['object' => 'category', 'mode' => 'preview', 'format' => 'jpg', 'file' => $entity->image_desc]) }}" alt="" />
                            </div>
                        </div>
                        @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'image_desc_delete', 'default' => 0])
                    @endif
                </div>
            </div>
            @foreach (Config::get('app.locales') as $i => $locale)
            <div class="tab-pane" id="tab-{{ $locale }}">
                <div class="row">
                    @include('manager.partials.form_control_translated', ['type' => 'text', 'field' => 'title', 'locale' => $locale])
                    @include('manager.partials.form_control_translated', ['type' => 'textarea', 'field' => 'description', 'locale' => $locale, 'controlClass' => 'tinymce'])
                </div>
            </div>
            @endforeach
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer')
        </div>
    {{ Form::close() }}
</div>
