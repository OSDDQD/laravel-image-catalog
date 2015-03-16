<?php

namespace Pizza;

class ConstructorController extends \BaseController {

    public function index()
    {

        $categories = IngredientsCategory::with('translations', 'ingredients', 'ingredients.translations', 'ingredients.options')->whereIsVisible(true)->orderBy('position')->get();
        $pizzas = Pizza::with('translations')->whereIsVisible(true)->whereIsPrepared(false)->orderBy('position')->get();

        $pizza = [];
        $item = [];

        $pizza[0]['title'] = \Lang::get('pizzas.constructor.base');
        foreach ($pizzas as $key => $value) {
            $pizza[0]['ingredient'][$key] = [
                'id' => $value->id,
                'title' => $value->title,
                #'position' => $value->position,
                'max_weight' => $value->max_weight,
                'size' => $value->size,
                'image' => $value->image,
                'base' => true,
            ];
        }

        foreach ($categories as $key => $value) {
            $item[$key]['id'] = $value->id;
            $item[$key]['title'] = $value->title;
            #$items[$key]['position'] = $value->position;
            foreach ($value->ingredients as $ikey => $ingredient) {
                $item[$key]['ingredient'][$ikey]['id'] = $ingredient->id;
                $item[$key]['ingredient'][$ikey]['title'] = $ingredient->title;
                #$items[$key]['ingredient'][$ikey]['position'] = $item->position;
                $item[$key]['ingredient'][$ikey]['image'] = $ingredient->image;
                foreach ($ingredient->options as $okey => $option) {
                    $item[$key]['ingredient'][$ikey]['option'][$okey]['pizza_id'] = $option->pizza_id;
                    $item[$key]['ingredient'][$ikey]['option'][$okey]['price'] = $option->price;
                    $item[$key]['ingredient'][$ikey]['option'][$okey]['max_quantity'] = $option->max_quantity;
                    $item[$key]['ingredient'][$ikey]['option'][$okey]['weight'] = $option->weight;
                }
            }
        }
//        var_dump(array_merge($pizza, $item));
//        exit();
        $items = array_merge($pizza, $item);
        $json = json_encode(array_merge($pizza, $item), JSON_UNESCAPED_UNICODE);

        return \View::make('pizza.constructor.index', [
            'pageTitle' => \Lang::get('pizzas.constructor.title'),
            'items' => $items,
            'json' => $json,
        ]);
    }

    public function add()
    {

    }

}
