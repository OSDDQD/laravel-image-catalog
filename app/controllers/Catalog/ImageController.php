<?php

namespace Catalog;

class ImageController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index($id)
    {
        $album = Album::find($id);
        if (!$album)
            return \Response::view('errors.404', [], 404);

        $itemsOnMenu = 15;

        $images = Image::with('translations')->whereAlbumId($album->id)->orderBy('position')->paginate($itemsOnMenu);
        foreach ($images as $image) {
            $image->title = '<a href="' . \URL::Route('manager.catalog.images.edit', ['id' => $image->id]) . '">' . $image->title . '</a>';
        }
        unset($itemsOnMenu);

        return \View::make('manager.index', [
            'entities' => $images,
            'fields' => ['title', 'is_visible'],
            'actions' => ['edit'],
            'slug' => 'image',
            'routeSlug' => 'catalog.images',
            'categoryId' => $album['category_id'],
            'toolbar' => [
                ['label' => \Lang::get('buttons.create'), 'class' => 'success', 'route' => 'manager.catalog.images.create', 'routeParams' => ['albumId' => $album['id']]],
                ['label' => \Lang::get('buttons.back_to_list'), 'class' => 'primary', 'route' => 'manager.catalog.albums.index', 'routeParams' => ['categoryId' => $album['category_id']]],
            ],
            'headerSubtext' => '(' . \Lang::choice('entities.album.inf', 1) . ' "' . $album->title . '")',
            'fieldAsIndex' => 'position',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create($albumId)
    {
        return \View::make('manager.create', [
            'entity' => new Image(['album_id' => $albumId]),
            'slug' => 'image',
            'routeSlug' => 'catalog.images',
            'indexRouteParams' => ['id' => $albumId],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Response
     */
    public function store()
    {
        $image = new Image(\Input::except(['options, image']));
        if (!$image->save()) {
            return \Redirect::back()->withInput()->withErrors($image->getErrors());
        }

        if (\Input::file('image')) {
            if (!$image->uploadImage(\Input::file('image'), 'image')) {
                $image->delete();
                return \Redirect::back()->withInput()->withErrors($image->getErrors());
            }
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
            ' <a href="' . \URL::Route('manager.catalog.images.edit', ['id' => $image->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.catalog.images.index', ['id' => $image->album_id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Response
     */
    public function edit($id)
    {
        $image = Image::find($id);

        return \View::make('manager.edit', [
            'entity' => $image,
            'slug' => 'image',
            'routeSlug' => 'catalog.images',
            'indexRouteParams' => ['id' => $image->album_id],
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Response
     */
    public function update($id)
    {
        $image = Image::find($id);
        if (!$image)
            return \Response::View('errors.404', [], 404);

        if (!$image->update(\Input::except(['image_delete', 'image']))) {
            return \Redirect::back()->withInput()->withErrors($image->getErrors());
        }

        $imageDelete = \Input::exists('image_delete') ? \Input::get('image_delete') : false;
        $imageFile = \Input::exists('image') ? \Input::file('image') : false;

        if ($imageDelete) {
            $image->removeImage('image');
        } elseif ($imageFile) {
            if (!$image->uploadImage($imageFile, 'image')) {
                return \Redirect::back()->withInput()->withErrors($image->getErrors());
            }
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
            ' <a href="' . \URL::Route('manager.catalog.images.edit', ['id' => $image->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.catalog.images.index', ['id' => $image->album_id]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Response
     */
    public function destroy()
    {
        $ids = \Input::get('id');
        foreach ($ids as $id) {
            $image = Image::find($id);
            if (!$image)
                continue;
            $image->removeImage('image');
            Image::destroy($id);
        }
        \Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
        return \Redirect::back();
    }


}
