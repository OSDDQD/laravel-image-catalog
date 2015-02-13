{{--@if (isset($footerPhones))
<div class="left">
   @foreach($footerPhones as $phone)
   <span>{{ trim($phone) }}</span>
   @endforeach
</div>
@endif--}}
<div class="right">
    <ul>
{{--        <li class="cart"><a href="#" class="arrow-box">2</a></li>--}}
        <li class="auth">
        @if (Auth::guest())
        <a href="{{ URL::Route('users.login') }}">{{ Lang::get('client.sign_in') }}</a>
        @else
        <a href="{{ URL::Route('users.profile') }}">{{ Lang::get('client.user_profile') }}</a>
        @endif
        </li>
    </ul>
</div>