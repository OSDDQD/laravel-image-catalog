@foreach ($entities as $entity)
    <div class="newsBlock">
        <h2 class="anonsTitle"><a href="{{ URL::Route('materials.news.display', ['id' => $entity->id]) }}">{{ date('d/m/Y', strtotime($entity->created_at)) }}</a></h2>
        {{ (isset($textShorten) and (int) $textShorten) ?
            mb_substr(strip_tags($entity->text, '<p><div><span><br>'), 0, (int) $textShorten, 'UTF-8') . '&hellip;' :
            $entity->text }}
    </div>
@endforeach
<a class="bigButton" href="{{ URL::Route('archive', ['type' => 'news']) }}">{{ Lang::get('client.go_to_archive') }}</a>
@if (method_exists($entities, 'links'))
    {{ $entities->links() }}
@endif