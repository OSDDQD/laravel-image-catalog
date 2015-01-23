@extends('layouts.client_noslider')

@section('content')
                <div class="blockReg">
                    <div class="formReg">
                        {{ Form::open(['route' => 'users.register']) }}
                            <div>
                                <p>{{ Form::label('username', Lang::get('fields.username')) }}</p>
                                {{ Form::text('username', null, ['maxlength' => 25]) }}
                                {{ $errors->first('username', '<div class="errorRedMessage">:message</div>')}}
                                <span>{{ Lang::get('forms.labels.username_rules') }}</span>
                            </div>
                            <div>
                                <p>{{ Form::label('displayname', Lang::get('fields.displayname')) }}</p>
                                {{ Form::text('displayname') }}
                                {{ $errors->first('displayname', '<div class="errorRedMessage">:message</div>')}}
                                <span>{{ Lang::get('forms.labels.displayname_rules') }}</span>
                            </div>
                            <div>
                                <p>{{ Form::label('password', Lang::get('fields.password')) }}</p>
                                {{ Form::password('password') }}
                                {{ $errors->first('password', '<div class="errorRedMessage">:message</div>')}}
                                <span>{{ Lang::get('forms.labels.password_rules') }}</span>
                            </div>
                            <div>
                                <p>{{ Form::label('password_confirmation', Lang::get('forms.labels.password_confirmation')) }}</p>
                                {{ Form::password('password_confirmation') }}
                                {{ $errors->first('password_confirmation', '<div class="errorRedMessage">:message</div>')}}
                                <span>{{ Lang::get('forms.labels.password_confirmation_rules') }}</span>
                            </div>
                            <div>
                                <p>{{ Form::label('email', Lang::get('fields.email')) }}</p>
                                {{ Form::email('email') }}
                                {{ $errors->first('email', '<div class="errorRedMessage">:message</div>')}}
                                <span>{{ Lang::get('forms.labels.email_rules') }}</span>
                            </div>
                            <div class="bDay">
                                <div>
                                    <p>{{ Form::label('fields.birthday', Lang::get('fields.birthday')) }}</p>
                                    {{ Form::date('birthday') }}
                                    {{ $errors->first('birthday', '<div class="errorRedMessage">:message</div>')}}
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
                            <div class="antiBot">
                                <p>{{ Lang::get('forms.labels.captcha') }}</p>
                                {{ HTML::image(Captcha::img(), 'Captcha image') }}
                                {{ Form::text('captcha', '') }}
                                {{ $errors->first('captcha', '<div class="antiBot errorRedMessage">:message</div>')}}
                                <div class="agree">
                                    <a href="#">{{ Lang::get('forms.labels.forgot_password') }}</a>
                                </div>
                                <div class="send">
                                    {{ Form::submit(Lang::get('buttons.submit')) }}
                                </div>
                                <div class="clear"></div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
@stop