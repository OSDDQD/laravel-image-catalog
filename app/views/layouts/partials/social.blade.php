<div class="socseti">
    <a href="{{ isset($socialFacebookUrl) ? $socialFacebookUrl : '#' }}" class="fsb"></a>
    <a href="{{ isset($socialTwitterUrl) ? $socialTwitterUrl : '#' }}" class="twt"></a>
    <a href="{{ isset($socialVkontakteUrl) ? $socialVkontakteUrl : '#' }}" class="vk"></a>
    <a href="{{ isset($socialOdnoklassnikiUrl) ? $socialOdnoklassnikiUrl : '#' }}" class="ok"></a>
    <a href="{{ URL::Route('rss', ['locale' => App::getLocale()]) }}" class="m"></a>
</div>