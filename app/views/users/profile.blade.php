@extends('layouts.client_noslider')

@section('content')

<div class="blockReg">
    <div class="formReg">
        {{ Form::open(['route' => 'users.update']) }}
            <div>
                <p>{{ Form::label('displayname', Lang::get('fields.displayname')) }}</p>
                {{ Form::text('displayname', $entity->displayname) }}
                {{ $errors->first('displayname', '<div class="errorRedMessage">:message</div>')}}
                <span>{{ Lang::get('forms.labels.displayname_rules') }}</span>
            </div>
            <div>
                <p>{{ Form::label('password', Lang::get('fields.password')) }}</p>
                {{ Form::password('password') }}
                {{ $errors->first('password', '<div class="errorRedMessage">:message</div>')}}
                <span>{{ Lang::get('forms.labels.password_no_change_if_empty') }}</span>
            </div>
            <div id="password_confirmation_container">
                <p>{{ Form::label('password_confirmation', Lang::get('forms.labels.password_confirmation')) }}</p>
                {{ Form::password('password_confirmation') }}
                {{ $errors->first('password_confirmation', '<div class="errorRedMessage">:message</div>')}}
                <span>{{ Lang::get('forms.labels.password_confirmation_rules') }}</span>
            </div>
            <div>
                <p>{{ Form::label('email', Lang::get('fields.email')) }}</p>
                {{ Form::email('email', $entity->email) }}
                {{ $errors->first('email', '<div class="errorRedMessage">:message</div>')}}
                <span>{{ Lang::get('forms.labels.email_rules') }}</span>
            </div>
            <div class="bDay">
                <div>
                    <p>{{ Form::label('fields.birthday', Lang::get('fields.birthday')) }}</p>
                    {{ Form::date('birthday', $entity->birthday) }}
                    {{ $errors->first('fields.birthday', '<div>:message</div>')}}
                </div>
                <div class="pol">
                    <p>{{ Lang::get('fields.sex') }}</p>
                    <ul class="radio-group">
                        <li>
                            <input id="choice-a" type="radio" name="is_female" value="0"{{ $entity->is_female ? null : ' checked="checked"' }}>
                            <label for="choice-a"><span class="polLet">{{ Lang::get('fields.sex_values.m') }}</span><span><span></span></span></label>
                        </li>
                        <li>
                            <input id="choice-b" type="radio" name="is_female" value="1"{{ $entity->is_female ? ' checked="checked"' : null }}>
                            <label for="choice-b"><span class="polLet">{{ Lang::get('fields.sex_values.f') }}</span><span><span></span></span></label>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div>
                <p>{{ Form::label('balance', Lang::get('fields.balance')) }}</p>
                {{ Form::text('balance', $entity->balance, ['readonly' => 'readonly']) }}
                <span>{{ Lang::get('forms.labels.balance_text') }}</span>
            </div>
            <div class="antiBot">
                <p>{{ Lang::get('forms.labels.captcha') }}</p>
                {{ HTML::image(Captcha::img(), 'Captcha image') }}
                {{ Form::text('captcha', '') }}
                {{ $errors->first('captcha', '<div class="antiBot errorRedMessage">:message</div>')}}
                <div class="send">
                    {{ Form::submit(Lang::get('buttons.save')) }}
                </div>
                <div class="clear"></div>
            </div>
        {{ Form::close() }}
    </div>
</div>

<script>
    $('#password_confirmation_container').hide();
    $('#password').on('keyup', function() {
        if ($('#password').val())
            $('#password_confirmation_container').slideDown();
        else
            $('#password_confirmation_container').slideUp();
    });
</script>

@stop