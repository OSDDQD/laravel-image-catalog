<?php

namespace Pizza;

class ConstructorController extends \BaseController {

    public function index()
    {

        $categories = IngredientsCategory::with('translations', 'ingredients', 'ingredients.translations')->orderBy('position')->get();
        foreach ($categories as $category) {
            print $category->title = '<a href="' . \URL::Route('manager.pizza.ingredients.index', ['categoryId' => $category->id]) . '">' . $category->title . '</a>';
            foreach ($category->ingredients as $ingredient) {
                print $ingredient->title;
            }
        }


        return \View::make('pizza.constructor.index', [
            'entities' => $categories,
        ]);
    }
}