@foreach ($entities as $entity)
    <div class="news-block">
        <div class="news-date">
            <span>{{ date('d.m.Y', strtotime($entity->created_at)) }}</span>
        </div>
        <div class="news-materials">
            <h2 class="anonsTitle"><a href="{{ URL::Route('materials.news.display', ['id' => $entity->id]) }}">{{ $entity->title }}</a></h2>
            {{ (isset($textShorten) and (int) $textShorten) ?
                mb_substr(strip_tags($entity->text, '<p><div><span><br>'), 0, (int) $textShorten, 'UTF-8') . '&hellip; <a href="' . URL::Route('materials.news.display', ['id' => $entity->id]) . '" class="read-more">подробнее&hellip;</a>' :
                $entity->text }}
        </div>
    </div>
@endforeach

@if (method_exists($entities, 'links'))
    {{ $entities->links() }}
@endif