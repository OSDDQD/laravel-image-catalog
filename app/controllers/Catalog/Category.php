<?php
namespace Catalog;

class Category extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /catalog/category
	 *
	 * @return Response
	 */
	public function index()
	{
		$itemsOnMenu = 15;

		$categories = Category::with('translations')->orderBy('position')->paginate($itemsOnMenu);
		foreach ($categories as $category) {
			$category->title = '<a href="' . \URL::Route('manager.categories.index', ['categoryId' => $category->id]) . '">' . $category->title . '</a>';
		}
		unset($itemsOnMenu);

		return \View::make('manager.index', [
			'entities' => $categories,
			'fields' => ['title', 'is_visible'],
			'actions' => ['show' => ['route' => 'manager.categories.index'], 'edit'],
			'slug' => 'category',
			'routeSlug' => 'categories',
			'fieldAsIndex' => 'position',
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /catalog/category/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('manager.create', [
			'entity' => new Category(),
			'slug' => 'category',
			'routeSlug' => 'categories',
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /catalog/category
	 *
	 * @return Response
	 */
	public function store()
	{
		$category = new Category(\Input::all());
		if (!$category->save()) {
			return \Redirect::back()->withInput()->withErrors($category->getErrors());
		}

		\Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
		                                           ' <a href="' . \URL::Route('manager.categories.edit', ['id' => $category->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
		return \Redirect::route('manager.categories.index');
	}

	/**
	 * Display the specified resource.
	 * GET /catalog/category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /catalog/category/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = Category::find($id);

		return \View::make('manager.edit', [
			'entity' => $category,
			'slug' => 'menu',
			'routeSlug' => 'categories',
		]);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /catalog/category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$category = Category::find($id);
		if (!$category)
			return \Response::View('errors.404', [], 404);

		if (!$category->update(\Input::all())) {
			return \Redirect::back()->withInput()->withErrors($category->getErrors());
		}

		\Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
		                                           ' <a href="' . \URL::Route('manager.categories.edit', ['id' => $category->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
		return \Redirect::route('manager.categories.index');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /catalog/category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$ids = \Input::get('id');
		foreach ($ids as $id) {
			$category = Category::find($id);
			if (!$category)
				continue;
			Category::destroy($id);
		}
		\Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
		return \Redirect::back();
	}

}