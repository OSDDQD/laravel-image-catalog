<div class="blockReg guest">
    <h2>{{ Lang::get('components.reviews._title') }}</h2>
    <div class="guestRed">
        @if (Session::has('guestbook_message'))
            <p>{{ Session::get('guestbook_message') }}</p>
        @endif
    </div>
    <div class="topBlog">
        <div class="blog">
            <div class="guestForm">
            {{ Form::open(['route' => 'guestbook.store', 'method' => 'post']) }}
                <div>
                    {{ Form::label('displayname', Lang::get('forms.labels.guestbook_displayname')) }}
                    @if (Auth::user())
                        <span class="authUser">{{ Auth::user()->displayname }}</span>
                    @else
                        {{ Form::text('displayname') }}
                    @endif
                    {{ $errors->first('displayname', '<div class="errorRedMessage">:message</div>')}}
                </div>
                <div class="textAreaBlog">
                    {{ Form::label('text', Lang::get('forms.labels.guestbook_text')) }}
                    {{ Form::textarea('text') }}
                    {{ $errors->first('text', '<div class="errorRedMessage">:message</div>')}}
                </div>
                @if (!Auth::user())
                    <div class="captcha">
                        {{ HTML::image(Captcha::img(), 'Captcha image') }}
                        {{ Form::text('captcha', '') }}
                        {{ $errors->first('captcha', '<div class="errorRedMessage">:message</div>')}}
                    </div>
                @endif
                <div class="send">
                    {{ Form::submit(Lang::get('buttons.submit')) }}
                </div>
                <div class="clear"></div>
            {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="reviews">
        @foreach ($entities as $entity)
        <div class="review">
            <p class="info">
                <span class="authUser">{{{ $entity->displayname }}}</span>
                <span class="dateOfPost">{{ date('d/m/Y', strtotime($entity->created_at)) }}</span>
            </p>
            <div class="textBlog">
                <p>{{{ $entity->text }}}</p>
            </div>
        </div>
        @endforeach
        {{ $entities->links() }}
    </div>
</div>