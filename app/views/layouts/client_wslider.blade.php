@extends('layouts.client_noslider')

@section('top_slider')
    @if (isset($topSliderData) and count($topSliderData))
    <section class="socialSlider">
        <div class="wrapper">
            <div id="showcase" class="showcase">
                <ul class="elements">
                    <li class="instagram"></li>
                    <li class="feedback"></li>
                    <li class="fb"></li>
                    <li class="twitter"></li>
                </ul>
                @foreach ($topSliderData as $image)
                <div class="showcase-slide">
                    <div class="showcase-content">
                        <img src="{{ \URL::Route('preview.managed', ['object' => 'slider', 'mode' => 'topimage', 'format' => 'jpg', 'file' => $image]) }}" alt="" />
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@stop
