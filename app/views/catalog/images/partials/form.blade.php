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
                        <div class="form-group{{ $errors->first('album_id') ? ' has-error' : null }}">
                            {{ Form::label('album_id', Lang::get('fields.album'), ['class' => 'control-label']) }}
                            <select class="form-control position-parent" id="album_id" name="album_id">
                                @foreach (Catalog\Album::with('translations', 'category', 'category.translations')->orderBy('category_id')->get() as $album)
                                    <option{{ $entity->album_id == $album->id ? ' selected="selected"' : null }} value="{{ $album->id }}">[{{ $album->category->title }}] {{ $album->title }}</option>
                                @endforeach
                            </select>
                            {{ $errors->first('album_id', '<span class="help-block has-error">:message</span>') }}
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
                    @include('manager.partials.form_control', ['type' => 'file', 'field' => 'image'])
                    @if (isset($entity->image) and $entity->image)
                    <div class="col-md-12">
                        <div class="form-group">
                            <img src="{{ \URL::Route('preview.managed', ['object' => 'image', 'mode' => 'preview', 'format' => 'jpg', 'file' => $entity->image]) }}" alt="" />
                        </div>
                    </div>
                    @include('manager.partials.form_control', ['type' => 'checkbox', 'field' => 'image_delete', 'default' => 0])
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
<script>
    $(function() {
        managePositions(
            '{{ json_encode(Catalog\Image::getByParentList(["parentField" => "album_id"])) }}',
            {{ $entity->id ? (int) $entity->album_id : 'undefined' }},
            {{ $entity->id ? 1 : 0 }},
            '{{ Lang::get("forms.labels.new_image") }}',
            {{ $entity->position ? $entity->position : 0 }}
        );
    });
</script>
