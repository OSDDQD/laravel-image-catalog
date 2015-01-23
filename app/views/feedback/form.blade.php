<div class="feedBack">
    @if (Session::has('feedback_message'))
        <div>{{ Session::get('feedback_message') }}</div>
    @endif
    {{ Form::open(['route' => 'feedback.send', 'method' => 'post']) }}
        <table class="feedBackTable">
            <tr>
                <td>
                    {{ Form::label('displayname', Lang::get('forms.labels.feedback_displayname')) }}
                </td>
                <td>
                    @if (Auth::user())
                        {{ Auth::user()->displayname }}
                    @else
                        {{ Form::text('displayname') }}
                        <p class="lineRight">{{ Form::label('email', Lang::get('forms.labels.feedback_email')) }} {{ Form::email('email') }}</p>
                        {{ $errors->first('displayname', '<div class="errorRedMessage forDisplayname">:message</div>')}}
                        {{ $errors->first('email', '<div class="errorRedMessage forEmail">:message</div>')}}
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('subject', Lang::get('forms.labels.feedback_subject')) }}
                </td>
                <td class="theme">
                    {{ Form::text('subject') }}
                    {{ $errors->first('subject', '<div class="errorRedMessage">:message</div>')}}
                </td>
            </tr>
            <tr>
                <td>
                    {{ Form::label('text', Lang::get('forms.labels.feedback_text')) }}
                </td>
                <td class="message">
                    {{ Form::textarea('text') }}
                    {{ $errors->first('text', '<div class="errorRedMessage">:message</div>')}}
                </td>
            </tr>
            @if (!Auth::user())
                <tr>
                    <td>
                        {{ Lang::get('forms.labels.captcha') }}
                    </td>
                    <td class="message">
                        {{ HTML::image(Captcha::img(), 'Captcha image') }}
                        <span class="feedKapcha"></span>
                        {{ Form::text('captcha', '') }}
                        {{ $errors->first('captcha', '<div class="errorRedMessage">:message</div>')}}
                    </td>
                </tr>
            @endif
            <tr>
                <td>

                </td>
                <td>
                    <div class="send">
                        {{ Form::submit(Lang::get('buttons.send')) }}
                    </div>
                </td>
            </tr>
        </table>
    {{ Form::close() }}
</div>