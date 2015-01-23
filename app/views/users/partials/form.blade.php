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
                    @include('manager.partials.form_control', ['type' => 'text', 'field' => 'username'])
                    @include('manager.partials.form_control', ['type' => 'text', 'field' => 'displayname'])
                    @include('manager.partials.form_control', ['type' => 'email', 'field' => 'email'])
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->first('password') ? ' has-error' : null }}">
                            {{ Form::label('password', Lang::get('fields.password'), ['class' => 'control-label']) }}
                            {{ Form::password('password', ['class' => 'form-control']) }}
                            <small>{{ Lang::get($entity->id ? 'forms.labels.password_no_change_if_empty' : null ) }}</small>
                            {{ $errors->first('password', '<span class="help-block has-error">:message</span>') }}
                        </div>
                    </div>
                    @include('manager.partials.form_control', ['type' => 'date', 'field' => 'birthday'])
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('roles', Lang::get('fields.roles'), ['class' => 'control-label']) }}
                            @foreach (Role::all() as $role)
                                <div class="form-control">
                                    {{ Form::label("roles[$role->id]", Lang::get("roles.$role->name"), ['class' => 'control-label']) }}
                                    {{ Form::checkbox("roles[$role->id]", $role->name, ($entity->hasRole($role->name) ? $role->name : 0)) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-footer">
            @include('manager.partials.form_footer')
        </div>
    {{ Form::close() }}
</div>
