<?php

namespace Pizza;

class ConstructorController extends \BaseController {

    public function index()
    {

        $categories = IngredientsCategory::with('translations', 'ingredients', 'ingredients.translations', 'ingredients.options')->whereIsVisible(true)->orderBy('position')->get();

        return \View::make('pizza.constructor.index', [
            'categories' => $categories,
            'pageTitle' => \Lang::get('pizzas.constructor'),
        ]);
    }

    public function add()
    {

    }

    public function menu()
    {
        $categories = IngredientsCategory::with('translations', 'ingredients', 'ingredients.translations', 'ingredients.options')->whereIsVisible(true)->orderBy('position')->get();

        return \View::make('pizza.constructor.partials.menu', [
            'menu' => $categories,
        ]);
    }
}