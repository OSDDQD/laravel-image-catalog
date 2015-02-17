<?php

namespace Pizza;

class ConstructorController extends \BaseController {

    public function index()
    {

        $categories = IngredientsCategory::with('translations', 'ingredients', 'ingredients.translations', 'ingredients.options')->whereIsVisible(true)->orderBy('position')->get();

        return \View::make('pizza.constructor.index', [
            'entities' => $categories,
        ]);
    }
}