<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-settings" data-toggle="tab">{{ Lang::get('forms.tabs.settings') }}</a></li>
        @foreach (Config::get('app.locales') as $i => $locale)
        <li><a href="#tab-{{ $locale }}" data-toggle="tab">{{ Lang::get("languages.$locale") }}</a></li>
        @endforeach
    </ul>
    @if($entity->id)
    {{ Form::open(['route' => ["manager.$routeSlug.update", $entity->id], 'method' => 'put', 'class' => 'form-vertical']) }}
    @else
    {{ Form::open(['route' => "manager.$routeSlug.store", 'class' => 'form-vertical']) }}
    @endif
        @include('manager.partials.form_control', ['type' => 'hidden', 'field' => 'menu_id'])
        <div class="tab-content">
            <div class="tab-pane active" id="tab-settings">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->first('parent_id') ? ' has-error' : null }}">
                            {{ Form::label('parent_id', Lang::get('fields.parent_page'), ['class' => 'control-label']) }}
                            <select class="form-control position-parent" id="parent_id" name="parent_id">
                                <option value="0">{{ Lang::get('forms.labels.new_root_page') }}</option>
                                @foreach (Structure\Page::getPossibleParentIds(['menuId' => $entity->menu_id, 'excluded' => ($entity->id ? [$entity->id] : [])]) as $page)
                                <option{{ $entity->parent_id == $page['id'] ? ' selected="selected"' : null }} value="{{ $page['id'] }}">{{ $page['title'] }}</option>
                                @endforeach
                            </select>
                            {{ $errors->first('parent_id', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->first('position') ? ' has-error' : null }}">
                            {{ Form::label('position', Lang::get('fields.position'), ['class' => 'control-label']) }}
                            {{ Form::select('position', [], null, ['class' => 'form-control']) }}
                            {{ $errors->first('position', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>

                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'is_visible', 'default' => 1])
                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'is_home', 'default' => 0])
                    <div class="col-md-12">
                        <div class="form-group"{{ $errors->first('template') ? ' has-error' : null }}>
                            {{ Form::label('template', Lang::get('fields.template'), ['class' => 'control-label']) }}
                            {{ Form::select('template',
                                Structure\Page::getPossibleTemplates(),
                                $entity->template, ['class' => 'form-control']) }}
                            {{ $errors->first('template', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group"{{ $errors->first('show_title') ? ' has-error' : null }}>
                            {{ Form::label('show_title', Lang::get('fields.show_title'), ['class' => 'control-label']) }}
                            {{ Form::select('show_title',
                                Structure\Page::getPossibleShowTitles(true),
                                ($entity->show_title ? $entity->show_title : 'page'), ['class' => 'form-control']) }}
                            {{ $errors->first('show_title', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group"{{ $errors->first('content_type') ? ' has-error' : null }}>
                            {{ Form::label('content_type', Lang::get('fields.content_type'), ['class' => 'control-label']) }}
                            {{ Form::select('content_type',
                                Structure\Page::getPossibleContentTypes(true),
                                $entity->content_type, ['class' => 'form-control']) }}
                            {{ $errors->first('content_type', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group"{{ $errors->first('content') ? ' has-error' : null }}>
                            {{ Form::label('content', Lang::get('fields.content'), ['class' => 'control-label']) }}
                            {{ Form::select('content_material',
                                Material::getPossibleMaterials(),
                                ($entity->content_type == Structure\Page::CONTENT_TYPE_MATERIAL ? $entity->content : 0),
                                ['data-type' => Structure\Page::CONTENT_TYPE_MATERIAL, 'id' => 'content_material', 'class' => 'form-control', 'style' => 'display: none']) }}
                            {{ Form::textarea('content_html',
                                ($entity->content_type == Structure\Page::CONTENT_TYPE_HTML ? $entity->content : null),
                                ['data-type' => Structure\Page::CONTENT_TYPE_HTML, 'id' => 'content_html', 'class' => 'form-control', 'style' => 'display: none']) }}
                            {{ Form::text('content_link',
                                ($entity->content_type == Structure\Page::CONTENT_TYPE_LINK ? $entity->content : 'http://'),
                                ['data-type' => Structure\Page::CONTENT_TYPE_LINK, 'id' => 'content_link', 'class' => 'form-control', 'style' => 'display: none']) }}
                            {{ Form::select('content_component',
                                Component::getList(),
                                ($entity->content_type == 'component' ? $entity->content : 0),
                                ['data-type' => 'component', 'id' => 'content_component', 'class' => 'form-control', 'style' => 'display: none']) }}
                            {{ $errors->first('content', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    @if ($entity->slug)
                        @include('manager.partials.form_control', ['type' => 'text', 'field' => 'slug'])
                    @endif
                </div>
            </div>
            @foreach (Config::get('app.locales') as $i => $locale)
            <div class="tab-pane" id="tab-{{ $locale }}">
                <div class="row">
                    @include('manager.partials.form_control_translated', ['type' => 'text', 'field' => 'title', 'locale' => $locale])
                    @include('manager.partials.form_control_translated', ['type' => 'text', 'field' => 'keywords', 'locale' => $locale])
                    @include('manager.partials.form_control_translated', ['type' => 'text', 'field' => 'description', 'locale' => $locale])
                </div>
            </div>
            @endforeach
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer')
        </div>
    {{ Form::close() }}
</div>
<script>
    $(function() {
        managePositions(
            '{{ json_encode(Structure\Page::getByParentList(["parentField" => "parent_id", "where" => ["menu_id" => $entity->menu_id]])) }}',
            {{ $entity->id ? (int) $entity->parent_id : 'undefined' }},
            {{ $entity->id ? 1 : 0 }},
            '{{ Lang::get("forms.labels.new_page") }}',
            {{ $entity->position ? $entity->position : 0 }}
        );

        $('#content_{{ $entity->content_type ? $entity->content_type : Structure\Page::CONTENT_TYPE_MATERIAL }}').show().attr('id', 'content').attr('name', 'content');
        if ($('#content_type').val() != '{{ Structure\Page::CONTENT_TYPE_MATERIAL }}')
            $('#show_title option[value="{{ Structure\Page::CONTENT_TYPE_MATERIAL }}"]').hide();
        $('#content_type').on('change', function() {
            var oldType = $('#content').data('type')
            $('#content').attr('id', 'content_' + oldType).attr('name', 'content_' + oldType).hide();
            var newType = $('#content_type').val();
            $('#content_' + newType).show().attr('id', 'content').attr('name', 'content');

            if (newType != '{{ Structure\Page::CONTENT_TYPE_MATERIAL }}') {
                $('#show_title option[value="{{ Structure\Page::SHOW_TITLE_MATERIAL }}"]').hide();
                if ($('#show_title').val() == '{{ Structure\Page::SHOW_TITLE_MATERIAL }}')
                    $('#show_title option[value="{{ Structure\Page::SHOW_TITLE_PAGE }}"]').prop('selected',true);
            } else {
                $('#show_title option[value="{{ Structure\Page::SHOW_TITLE_MATERIAL }}"]').show();
            }
        })
    })
</script>
