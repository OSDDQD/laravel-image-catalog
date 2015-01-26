<?php

namespace Pizza;

class IngredientsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index($id)
    {
        $categpry = IngredientsCategory::find($id);
        if (!$categpry)
            return \Response::view('errors.404', [], 404);

        $itemsOnMenu = 15;

        $ingredients = Ingredient::with('translations')->whereCategoryId($categpry->id)->orderBy('id')->paginate($itemsOnMenu);
        foreach ($ingredients as $ingredient) {
            $ingredient->title = '<a href="' . \URL::Route('manager.pizza.ingredients.index', ['id' => $ingredient->id]) . '">' . $ingredient->title . '</a>';
        }
        unset($itemsOnMenu);

        return \View::make('manager.index', [
            'entities' => $ingredients,
            'fields' => ['title', 'is_visible'],
            'actions' => ['edit'],
            'slug' => 'ingredient',
            'routeSlug' => 'pizza.ingredients',
            'toolbar' => [
                ['label' => \Lang::get('buttons.create'), 'class' => 'success', 'route' => 'manager.pizza.ingredients.create', 'routeParams' => ['categoryId' => $categpry['id']]],
                ['label' => \Lang::get('buttons.back_to_list'), 'class' => 'primary', 'route' => 'manager.pizza.icategories.index'],
            ],
            'headerSubtext' => '(' . \Lang::choice('entities.ingredients_category.inf', 1) . ' "' . $categpry->title . '")',
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
            'entity' => new Ingredient(['category_id' => $categoryId]),
            'slug' => 'ingredient',
            'routeSlug' => 'pizza.ingredients',
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
        $ingredient = new Ingredient(\Input::all());
        if (!$ingredient->save()) {
            return \Redirect::back()->withInput()->withErrors($ingredient->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
            ' <a href="' . \URL::Route('manager.pizza.ingredients.edit', ['id' => $ingredient->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.pizza.ingredients.index', ['id' => $ingredient->category_id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Response
     */
    public function edit($id)
    {
        $ingredient = Ingredient::find($id);

        return \View::make('manager.edit', [
            'entity' => $ingredient,
            'slug' => 'ingredient',
            'routeSlug' => 'pizza.ingredients',
            'indexRouteParams' => ['id' => $ingredient->category_id],
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
        $ingredient = Ingredient::find($id);
        if (!$ingredient)
            return \Response::View('errors.404', [], 404);

        if (!$ingredient->update(\Input::all())) {
            return \Redirect::back()->withInput()->withErrors($ingredient->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
            ' <a href="' . \URL::Route('manager.pizza.ingredients.edit', ['id' => $ingredient->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.pizza.ingredients.index', ['id' => $ingredient->category_id]);
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
            $ingredient = Pizza::find($id);
            if (!$ingredient)
                continue;
//            foreach ($ingredient->pages as $page) {
//                if ($page->is_home) {
//                    \Session::flash('manager_error_message', \Lang::get('manager.messages.menu_containing_home_page_cant_be_removed'));
//                    return \Redirect::back();
//                }
//            }
            Pizza::destroy($id);
        }
        \Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
        return \Redirect::back();
    }


}
