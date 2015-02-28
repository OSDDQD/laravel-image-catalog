<?php

namespace Pizza;

class PizzasController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index()
    {
        $itemsOnMenu = 15;

        $pizzas = Pizza::with('translations')->orderBy('position')->paginate($itemsOnMenu);
        foreach ($pizzas as $pizza) {
            $pizza->title = '<a href="' . \URL::Route('manager.pizza.pizzas.edit', ['id' => $pizza->id]) . '">' . $pizza->title . '</a>';
        }
        unset($itemsOnMenu);

        return \View::make('manager.index', [
            'entities' => $pizzas,
            'fields' => ['title', 'size', 'price',  'max_weight', 'is_visible', 'is_prepared', 'is_popular', 'is_novelty'],
            'actions' => [/*'show' => ['route' => 'manager.structure.pages.index'],*/ 'edit'],
            'slug' => 'pizza',
            'routeSlug' => 'pizza.pizzas',
            'fieldAsIndex' => 'position',
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
            'entity' => new Pizza(),
            'slug' => 'pizza',
            'routeSlug' => 'pizza.pizzas',
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Response
     */
    public function store()
    {
        $pizza = new Pizza(\Input::all());
        if (!$pizza->save()) {
            return \Redirect::back()->withInput()->withErrors($pizza->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
            ' <a href="' . \URL::Route('manager.pizza.pizzas.edit', ['id' => $pizza->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.pizza.pizzas.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Response
     */
    public function edit($id)
    {
        $pizza = Pizza::find($id);

        return \View::make('manager.edit', [
            'entity' => $pizza,
            'slug' => 'pizza',
            'routeSlug' => 'pizza.pizzas',
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
        $pizza = Pizza::find($id);
        if (!$pizza)
            return \Response::View('errors.404', [], 404);

        if (!$pizza->update(\Input::all())) {
            return \Redirect::back()->withInput()->withErrors($pizza->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
            ' <a href="' . \URL::Route('manager.pizza.pizzas.edit', ['id' => $pizza->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.pizza.pizzas.index');
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
            $pizza = Pizza::find($id);
            if (!$pizza)
                continue;
//            foreach ($pizza->pages as $page) {
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

    public function showRecipes() {
        return \View::make('pizza.pizzas.partials.recipes', [
        ]);
    }


}
