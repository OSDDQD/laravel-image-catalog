@foreach ($entities as $entity)
    <div class="tipBlock">
        <h2>
            <a href="{{ URL::Route('materials.news.display', ['id' => $entity->id]) }}">{{ $entity->title }}</a>
        </h2>
        <img src="{{ \URL::Route('preview.managed', ['object' => 'material', 'mode' => 'preview', 'format' => 'jpg', 'file' => $entity->image]) }}" alt="" />
        <span>
             {{ (isset($textShorten) and (int) $textShorten) ? mb_substr(strip_tags($entity->text, '<p><div><span><br>'), 0, (int) $textShorten, 'UTF-8') . '&hellip; ' : $entity->text }}
        </span>
    </div>
@endforeach

@if (method_exists($entities, 'links'))
    {{ $entities->links() }}
@endif
