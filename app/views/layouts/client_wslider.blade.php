@extends('layouts.client_noslider')

@section('top_slider')
    @if (isset($topSliderData) and count($topSliderData))
    <div id="showcase" class="showcase">
        @foreach ($topSliderData as $image)
        <div class="showcase-slide">
            <div class="showcase-content">
                <img src="{{ \URL::Route('preview.managed', ['object' => 'slider', 'mode' => 'topimage', 'format' => 'jpg', 'file' => $image]) }}" alt="" />
            </div>
        </div>
        @endforeach
    </div>
    @endif
@stop
