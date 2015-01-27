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
        <div class="tab-content">
            <div class="tab-pane active" id="tab-settings">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->first('category_id') ? ' has-error' : null }}">
                            {{ Form::label('category_id', Lang::get('fields.category'), ['class' => 'control-label']) }}
                            <select class="form-control position-parent" id="category_id" name="category_id">
                                @foreach (Pizza\IngredientsCategory::with('translations')->get() as $category)
                                    <option{{ $entity->category_id == $category->id ? ' selected="selected"' : null }} value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            {{ $errors->first('category_id', '<span class="help-block has-error">:message</span>') }}
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

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>{{ Lang::get('fields.pizza') }}</th>
                            <th>{{ Lang::get('fields.weight') }}</th>
                            <th>{{ Lang::get('fields.price') }}</th>
                            <th>{{ Lang::get('fields.max_quantity') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (Pizza\Pizza::with('translations')->get() as $pizza)
                            <tr>
                                <td>
                                    {{ $pizza->title }}
                                    @if ($pizza->size or $pizza->max_weight)
                                        <br>({{ ($pizza->size ? $pizza->size . ($pizza->max_weight ? ' / ' : '') : '') . $pizza->max_weight }})
                                    @endif
                                </td>
                                <td>
                                    {{ Form::text('options[' . $pizza->id . '][weight]', (isset($options[$pizza->id]['weight']) ? $options[$pizza->id]['weight'] : '0.00'), ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    {{ Form::text('options[' . $pizza->id . '][price]', (isset($options[$pizza->id]['price']) ? $options[$pizza->id]['price'] : '0.00'), ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    {{ Form::text('options[' . $pizza->id . '][max_quantity]', (isset($options[$pizza->id]['max_quantity']) ? $options[$pizza->id]['max_quantity'] : 0), ['class' => 'form-control']) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
            '{{ json_encode(Pizza\Ingredient::getByParentList(["parentField" => "category_id"])) }}',
            {{ $entity->id ? (int) $entity->category_id : 'undefined' }},
            {{ $entity->id ? 1 : 0 }},
            '{{ Lang::get("forms.labels.new_ingredient") }}',
            {{ $entity->position ? $entity->position : 0 }}
        );
    });
</script>
