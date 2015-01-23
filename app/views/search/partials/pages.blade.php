<div class="resultText">
    @foreach ($results as $result)
    <div>
        <a href="{{ URL::Route('pages.display', ['slug' => $result->slug]) }}">{{ $result->title }}</a>
        <p>{{ $result->text }}</p>
    </div>
    @endforeach
</div>