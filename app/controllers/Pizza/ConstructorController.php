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
                'max_weight' => round($value->max_weight),
                'size' => round($value->size),
                'image' => \URL::Route('preview.managed', ['object' => 'pizza', 'mode' => 'constructor', 'format' => 'jpg', 'file' => $value->image]),
                'price' => round($value->price),
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
                $item[$key]['ingredient'][$ikey]['position'] = $ingredient->position;
                $item[$key]['ingredient'][$ikey]['image'] = \URL::Route('preview.managed', ['object' => 'pizza-ingredient', 'mode' => 'constructor', 'format' => 'jpg', 'file' => $ingredient->image]);
            }
        }

        foreach ($categories as $categoryid => $category) {
            foreach ($category->ingredients as $ingredientid => $ingredient) {
                foreach ($ingredient->options as $key => $value) {
                    $option[$categoryid][$ingredientid][$key]['ingredient_id'] = $ingredient->id;
                    $option[$categoryid][$ingredientid][$key]['pizza_id'] = $value->pizza_id;
                    $option[$categoryid][$ingredientid][$key]['price'] = round($value->price, 0);
                    $option[$categoryid][$ingredientid][$key]['max_quantity'] = $value->max_quantity;
                    $option[$categoryid][$ingredientid][$key]['weight'] = round($value->weight);
                }
            }
        }
//        var_dump(array_merge($pizza, $item));
//        exit();
        $items = array_merge($pizza, $item);
        $json = json_encode(array_merge($pizza, $item), JSON_UNESCAPED_UNICODE);
        $options = json_encode($option, JSON_UNESCAPED_UNICODE);

        return \View::make('pizza.constructor.index', [
            'pageTitle' => \Lang::get('pizzas.constructor.title'),
            'items' => $items,
            'json' => $json,
            'options' => $options,
        ]);
    }

    public function add()
    {

    }

}
