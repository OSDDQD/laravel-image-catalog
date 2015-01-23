@extends('layouts.client')

@section('header')
@parent
@stop

@section('body')

<div class="body">
    <div class="wrapper">
        <div class="logo"></div>
        <div class="zip">
            <div class="switch">
                <a href="{{ URL::Route('home') }}"></a>
            </div>
            <div class="clear"></div>
            <audio id="beep-one" preload="auto">
                <source src="/assets/audio/th_gtr.wav"></source>
                <source src="/assets/audio/audio/th_gtr.wav"></source>
                Ваш браузер не поддерживает замечательный элемент &lt;audio&gt;.
            </audio>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="flash">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" id="zipper" class="ggg" align="middle">
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="movie" value="/assets/img/client/zipper.swf" />
                <param name="quality" value="high" />
                <param name="wmode" value="transparent" />
                <param name="bgcolor" value="transparent" />
                <embed src="/assets/img/client/zipper.swf" quality="high" wmode="transparent" bgcolor="transparent" name="zipper" align="middle" swLiveConnect="true" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_ru"/>
            </object>
        </div>
    </div>
</div>
@stop
@section('footer')
@stop