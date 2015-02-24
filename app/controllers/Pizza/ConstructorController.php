<?php

namespace Pizza;

class ConstructorController extends \BaseController {

    public function index()
    {

        $categories = IngredientsCategory::with('translations', 'ingredients', 'ingredients.translations', 'ingredients.options')->whereIsVisible(true)->orderBy('position')->get();

        $pizzas = Pizza::whereIsVisible(true)->get();

        $menu = [];

        foreach ($pizzas as $key => $value) {
            $menu['pizza'][$key] = [
                'title' => $value->title,
                'position' => $value->position,
                'max_weight' => $value->max_weight,
                'size' => $value->size,
                'id' => $value->id,
            ];
        }

        foreach ($categories as $key => $value) {
            $menu['category'][$key]['id'] = $value->id;
            $menu['category'][$key]['title'] = $value->title;
            $menu['category'][$key]['position'] = $value->position;
            foreach ($value->ingredients as $ikey => $ingredient) {
                $menu['category'][$key]['ingredient'][$ikey]['id'] = $ingredient->id;
                $menu['category'][$key]['ingredient'][$ikey]['title'] = $ingredient->title;
                $menu['category'][$key]['ingredient'][$ikey]['position'] = $ingredient->position;
                foreach ($ingredient->options as $okey => $option) {
                    $menu['category'][$key]['ingredient'][$ikey]['option'][$okey]['pizza_id'] = $option->pizza_id;
                    $menu['category'][$key]['ingredient'][$ikey]['option'][$okey]['price'] = $option->price;
                    $menu['category'][$key]['ingredient'][$ikey]['option'][$okey]['max_quantity'] = $option->max_quantity;
                    $menu['category'][$key]['ingredient'][$ikey]['option'][$okey]['weight'] = $option->weight;
                }
            }
        }

        $menu = json_encode($menu, JSON_UNESCAPED_UNICODE);

        return \View::make('pizza.constructor.index', [
            'categories' => $categories,
            'pageTitle' => \Lang::get('pizzas.constructor'),
            'jsonMenu' => $menu,
        ]);
    }

    public function add()
    {

    }

}