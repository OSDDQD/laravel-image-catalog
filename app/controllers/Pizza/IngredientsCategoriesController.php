<?php

namespace Pizza;

class IngredientsCategoriesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index()
    {
        $itemsOnMenu = 15;

        $categories = IngredientsCategory::with('translations')->orderBy('id')->paginate($itemsOnMenu);
        foreach ($categories as $category) {
            $category->title = '<a href="' . \URL::Route('manager.pizza.icategories.index', ['id' => $category->id]) . '">' . $category->title . '</a>';
        }
        unset($itemsOnMenu);

        return \View::make('manager.index', [
            'entities' => $categories,
            'fields' => ['title', 'is_visible'],
            'actions' => ['show' => ['route' => 'manager.pizza.ingredients.index'], 'edit'],
            'slug' => 'ingredients_category',
            'routeSlug' => 'pizza.icategories',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return \View::make('manager.create', [
            'entity' => new IngredientsCategory(),
            'slug' => 'ingredients_category',
            'routeSlug' => 'pizza.icategories',
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Response
     */
    public function store()
    {
        $category = new IngredientsCategory(\Input::all());
        if (!$category->save()) {
            return \Redirect::back()->withInput()->withErrors($category->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
            ' <a href="' . \URL::Route('manager.pizza.icategories.edit', ['id' => $category->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.pizza.icategories.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Response
     */
    public function edit($id)
    {
        $category = IngredientsCategory::find($id);

        return \View::make('manager.edit', [
            'entity' => $category,
            'slug' => 'menu',
            'routeSlug' => 'pizza.icategories',
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
        $category = IngredientsCategory::find($id);
        if (!$category)
            return \Response::View('errors.404', [], 404);

        if (!$category->update(\Input::all())) {
            return \Redirect::back()->withInput()->withErrors($category->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
            ' <a href="' . \URL::Route('manager.pizza.icategories.edit', ['id' => $category->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.pizza.icategories.index');
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
            $category = IngredientsCategory::find($id);
            if (!$category)
                continue;
//            foreach ($category->pages as $page) {
//                if ($page->is_home) {
//                    \Session::flash('manager_error_message', \Lang::get('manager.messages.menu_containing_home_page_cant_be_removed'));
//                    return \Redirect::back();
//                }
//            }
            IngredientsCategory::destroy($id);
        }
        \Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
        return \Redirect::back();
    }


}
