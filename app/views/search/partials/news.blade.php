<div class="resultText">
    @foreach ($results as $result)
    <div>
        <a href="{{ URL::Route('materials.news.display', ['id' => $result->id]) }}">{{ $result->title }}</a>
        <p>{{ mb_substr(strip_tags($result->text), 0, 250, 'UTF-8') }}&hellip;</p>
    </div>
    @endforeach
</div>