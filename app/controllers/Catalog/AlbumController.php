<?php

namespace Catalog;

class AlbumController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Response
	 */
	public function index($id)
	{
		$category = Category::find($id);
		if (!$category)
			return \Response::view('errors.404', [], 404);

		$itemsOnMenu = 15;

		$albums = Album::with('translations')->whereCategoryId($category->id)->orderBy('position')->paginate($itemsOnMenu);
		foreach ($albums as $album) {
			$album->title = '<a href="' . \URL::Route('manager.catalog.images.index', ['albumId' => $album->id]) . '">' . $album->title . '</a>';
		}
		unset($itemsOnMenu);

		return \View::make('manager.index', [
			'entities' => $albums,
			'fields' => ['title', 'is_visible'],
			'actions' => ['show' => ['route' => 'manager.catalog.images.index'], 'edit'],
			'slug' => 'album',
			'routeSlug' => 'catalog.albums',
			'toolbar' => [
				['label' => \Lang::get('buttons.create'), 'class' => 'success', 'route' => 'manager.catalog.albums.create', 'routeParams' => ['categoryId' => $category['id']]],
				['label' => \Lang::get('buttons.back_to_list'), 'class' => 'primary', 'route' => 'manager.catalog.categories.index'],
			],
			'headerSubtext' => '(' . \Lang::choice('entities.category.inf', 1) . ' "' . $category->title . '")',
			'fieldAsIndex' => 'position',
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Response
	 */
	public function create($categoryId)
	{
		return \View::make('manager.create', [
			'entity' => new Album(['category_id' => $categoryId]),
			'slug' => 'album',
			'routeSlug' => 'catalog.albums',
			'indexRouteParams' => ['id' => $categoryId],
		]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return \Response
	 */
	public function store()
	{
		$album = new Album(\Input::except(['options, image']));
		if (!$album->save()) {
			return \Redirect::back()->withInput()->withErrors($album->getErrors());
		}

		if (\Input::file('image')) {
			if (!$album->uploadImage(\Input::file('image'), 'image')) {
				$album->delete();
				return \Redirect::back()->withInput()->withErrors($album->getErrors());
			}
		}

		\Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
		                                           ' <a href="' . \URL::Route('manager.catalog.albums.edit', ['id' => $album->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
		return \Redirect::route('manager.catalog.albums.index', ['id' => $album->category_id]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Response
	 */
	public function edit($id)
	{
		$album = Album::find($id);

		return \View::make('manager.edit', [
			'entity' => $album,
			'slug' => 'album',
			'routeSlug' => 'catalog.albums',
			'indexRouteParams' => ['id' => $album->category_id],
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
		$album = Album::find($id);
		if (!$album)
			return \Response::View('errors.404', [], 404);

		if (!$album->update(\Input::except(['image_delete', 'image']))) {
			return \Redirect::back()->withInput()->withErrors($album->getErrors());
		}

		$imageDelete = \Input::exists('image_delete') ? \Input::get('image_delete') : false;
		$imageFile = \Input::exists('image') ? \Input::file('image') : false;

		if ($imageDelete) {
			$album->removeImage('image');
		} elseif ($imageFile) {
			if (!$album->uploadImage($imageFile, 'image')) {
				return \Redirect::back()->withInput()->withErrors($album->getErrors());
			}
		}

		\Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
		                                           ' <a href="' . \URL::Route('manager.catalog.albums.edit', ['id' => $album->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
		return \Redirect::route('manager.catalog.albums.index', ['id' => $album->category_id]);
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
			$album = Album::find($id);
			if (!$album)
				continue;
            $album->removeImage('image');
			Album::destroy($id);
		}
		\Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
		return \Redirect::back();
	}

	public function show($id)
	{
		$images = Image::with('translations')->whereAlbumId($id)->whereIsVisible(true)->orderBy('position')->paginate(18);
		if (!$images)
			return \Response::view('errors.404', [], 404);

        $album = Album::find($id);
        $category = Category::with('translations')->find($album->category_id);

		return \View::make('catalog.albums.index', [
			'entity' => $images,
            'category' => $category,
		]);
	}


}
