<?php

class EditorController extends BaseController
{

    public function components()
    {
        $list = [];

        $components = Component::all(['name']);
        foreach($components as $component)
            $list[] = ['text' => Lang::get("components.$component->name._title"), 'value' => $component->name];

        return json_encode($list);
    }

    public function modules()
    {
        $list = [
            ['text' => Lang::get("modules.sample._title"), 'value' => 'sample'],
        ];

        return json_encode($list);
    }

    public function galleryalbums()
    {
        $list = [];

        $albums = Gallery\Album::with('translations')->get();
        foreach($albums as $album)
            $list[] = ['text' => $album->title, 'value' => $album->id];

        return json_encode($list);
    }

    public function galleryphotos()
    {
        $list = [];

        $photos = Gallery\Photo::with('translations')->get();
        foreach($photos as $photo)
            $list[] = ['text' => $photo->title ? $photo->title : $photo->id, 'value' => $photo->id];

        return json_encode($list);
    }

    public function videoalbums()
    {
        $list = [];

        $albums = Video\Album::with('translations')->get();
        foreach($albums as $album)
            $list[] = ['text' => $album->title, 'value' => $album->id];

        return json_encode($list);
    }

    public function videoclips()
    {
        $list = [];

        $clips = Video\Clip::with('translations')->get();
        foreach($clips as $clip)
            $list[] = ['text' => $clip->title, 'value' => $clip->id];

        return json_encode($list);
    }

}