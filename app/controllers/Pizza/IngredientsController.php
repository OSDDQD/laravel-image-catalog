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
        $category = IngredientsCategory::find($id);
        if (!$category)
            return \Response::view('errors.404', [], 404);

        $itemsOnMenu = 15;

        $ingredients = Ingredient::with('translations')->whereCategoryId($category->id)->orderBy('position')->paginate($itemsOnMenu);
        foreach ($ingredients as $ingredient) {
            $ingredient->title = '<a href="' . \URL::Route('manager.pizza.ingredients.edit', ['id' => $ingredient->id]) . '">' . $ingredient->title . '</a>';
        }
        unset($itemsOnMenu);

        return \View::make('manager.index', [
            'entities' => $ingredients,
            'fields' => ['title', 'is_visible'],
            'actions' => ['edit'],
            'slug' => 'ingredient',
            'routeSlug' => 'pizza.ingredients',
            'toolbar' => [
                ['label' => \Lang::get('buttons.create'), 'class' => 'success', 'route' => 'manager.pizza.ingredients.create', 'routeParams' => ['categoryId' => $category['id']]],
                ['label' => \Lang::get('buttons.back_to_list'), 'class' => 'primary', 'route' => 'manager.pizza.icategories.index'],
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
        if (!$options = \Input::get('options'))
            $options = [];

        return \View::make('manager.create', [
            'entity' => new Ingredient(['category_id' => $categoryId]),
            'slug' => 'ingredient',
            'routeSlug' => 'pizza.ingredients',
            'indexRouteParams' => ['id' => $categoryId],
            'options' => $options,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Response
     */
    public function store()
    {
        $ingredient = new Ingredient(\Input::except('options'));
        if (!$ingredient->save()) {
            return \Redirect::back()->withInput()->withErrors($ingredient->getErrors());
        }

        $pizzas = [];
        $options = \Input::get('options');
        foreach(array_keys($options) as $pizza) {
            if (!isset($pizzas[$pizza])) {
                $pizza = Pizza::find($pizza);
                $pizzas[$pizza->id] = $pizza;
            } else {
                $pizza = $pizzas[$pizza];
            }
            if (!$pizza instanceof Pizza)
                return \Redirect::route('manager.pizza.ingredients.edit', ['id' => $ingredient->id])->withInput();

            $option = new Option($options[$pizza->id]);
            $option->pizza_id = $pizza->id;
            $option->ingredient_id = $ingredient->id;
            if (!$option->save())
                return \Redirect::route('manager.pizza.ingredients.edit', ['id' => $ingredient->id])->withInput();
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

        if (!$options = \Input::get('options')) {
            $options = [];
            $optionsData = Option::whereIngredientId($ingredient->id)->get();
            foreach ($optionsData as $data) {
                $options[$data->pizza_id] = [
                    'weight' => $data->weight,
                    'price' => $data->price,
                    'max_quantity' => $data->max_quantity,
                ];
            }
        }

        return \View::make('manager.edit', [
            'entity' => $ingredient,
            'slug' => 'ingredient',
            'routeSlug' => 'pizza.ingredients',
            'indexRouteParams' => ['id' => $ingredient->category_id],
            'options' => $options,
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

        $pizzas = [];
        $options = \Input::get('options');
        foreach(array_keys($options) as $pizza) {
            if (!isset($pizzas[$pizza])) {
                $pizza = Pizza::find($pizza);
                $pizzas[$pizza->id] = $pizza;
            } else {
                $pizza = $pizzas[$pizza];
            }
            if (!$pizza instanceof Pizza)
                return \Redirect::route('manager.pizza.ingredients.edit', ['id' => $ingredient->id])->withInput();

            $option = new Option($options[$pizza->id]);
            $option->pizza_id = $pizza->id;
            $option->ingredient_id = $ingredient->id;
            if (!$option->save())
                return \Redirect::route('manager.pizza.ingredients.edit', ['id' => $ingredient->id])->withInput();
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
            $ingredient = Ingredient::find($id);
            if (!$ingredient)
                continue;
            Ingredient::destroy($id);
        }
        \Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
        return \Redirect::back();
    }


}
