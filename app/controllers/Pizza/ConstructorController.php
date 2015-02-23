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
        $pizzas = Pizza::whereIsVisible(true)->get();

        $menu = [];

        foreach ($pizzas as $pizza) {
            $menu['pizza'][$pizza->id]['title'] = $pizza->title;
            $menu['pizza'][$pizza->id]['position'] = $pizza->position;
            $menu['pizza'][$pizza->id]['max_weight'] = $pizza->max_weight;
            $menu['pizza'][$pizza->id]['size'] = $pizza->size;
        }

        foreach ($categories as $category) {
            $menu['category'][$category->id]['title'] = $category->title;
            $menu['category'][$category->id]['position'] = $category->position;
            foreach ($category->ingredients as $ingredient) {
                $menu['category'][$category->id]['ingredient'][$ingredient->id]['title'] = $ingredient->title;
                $menu['category'][$category->id]['ingredient'][$ingredient->id]['position'] = $ingredient->position;
                foreach ($ingredient->options as $option) {
                    $menu['category'][$category->id]['ingredient'][$ingredient->id]['option']['pizzaid'] = $option->pizzaid;
                    $menu['category'][$category->id]['ingredient'][$ingredient->id]['option']['price'] = $option->price;
                    $menu['category'][$category->id]['ingredient'][$ingredient->id]['option']['max_quantity'] = $option->max_quantity;
                    $menu['category'][$category->id]['ingredient'][$ingredient->id]['option']['weight'] = $option->weight;
                }
            }
        }

        $menu = json_encode($menu, JSON_UNESCAPED_UNICODE);

        return \View::make('pizza.constructor.partials.menu', [
            'menu' => $menu,
        ]);
    }
}