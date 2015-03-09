<?php
namespace Menu;

class HomeController extends \BaseController {

    public function index () {

        $pizzas = \Pizza\Pizza::with('translations')->whereIsPrepared(true)->orderBy('position', 'DESC')->whereIsVisible(true)->get();
        $additional = Category::with('translations', 'items.translations')->with
            (['items' => function($query) {
                $query->where('is_visible', '=', true);
            }])
            ->whereIsVisible(true)->orderBy('position', 'DESC')->get();

        return \View::make('menu.index', [
            'pizzas' => $pizzas,
            'additional' => $additional,
            'pageTitle' => \Lang::get('pizzas.our_menu'),
        ]);
    }

    public function show ($id) {

    }

    public function fetch ($category_id, $page = 1, $limit = 8) {

        $results = Item::with('translations')->whereCategoryId($category_id)->whereIsVisible(true)->skip($limit * ($page - 1))->orderBy('position', 'DESC')->get();

        return $results;
    }
}