@foreach ($entities as $material)
   <strong>{{ $material->title }}</strong><br />
    @foreach ($material->ingredients as $ingredient)
        {{ $ingredient->title }}
        @foreach($ingredient->options as $option)
            {{ $option }}<br>
        @endforeach
    @endforeach
@endforeach