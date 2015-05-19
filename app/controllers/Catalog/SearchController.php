<?php

namespace Catalog;

class SearchController extends \BaseController {

    public function search() {

        $category = NULL;
        $albums = NULL;
        $images = NULL;

        $query = \InputProtect::get('q');

        if(!isset($query))
            $query = false;


        if($query) {
            //Мама, прости меня за это.
            $locale = \Session::get('locale');
            if ($locale and in_array($locale, \Config::get('app.locales')))
                \App::setLocale($locale);

            $albums = \DB::select(\DB::raw(
                "SELECT * FROM
            catalog_albums_translations as albums_trans
            LEFT JOIN catalog_albums as albums ON albums.id=albums_trans.album_id
            WHERE albums_trans.description LIKE :desc
            OR albums_trans.title LIKE :title
            AND albums_trans.locale = :locale
            AND albums.is_visible = :visible
            "), array(
                'title' => '%'.$query.'%',
                'desc' => '%'.$query.'%',
                'visible' => true,
                'locale' => \Session::get('locale'),
            ));

            $images = \DB::select(\DB::raw(
                "SELECT * FROM
            catalog_images_translations as images_trans
            LEFT JOIN catalog_images as images ON images.id=images_trans.image_id
            WHERE images_trans.description LIKE :desc
            OR images_trans.title LIKE :title
            AND images_trans.locale = :locale
            AND images.is_visible = :visible
            "), array(
                'title' => '%'.$query.'%',
                'desc' => '%'.$query.'%',
                'visible' => true,
                'locale' => \Session::get('locale'),
            ));

            $category = \DB::select(\DB::raw(
                "SELECT * FROM
            catalog_categories_translations as categories_trans
            LEFT JOIN catalog_categories as categories ON categories.id=categories_trans.category_id
            WHERE categories_trans.description LIKE :desc
            OR categories_trans.title LIKE :title
            AND categories_trans.locale = :locale
            AND categories.is_visible = :visible
            "), array(
                'title' => '%'.$query.'%',
                'desc' => '%'.$query.'%',
                'visible' => true,
                'locale' => \Session::get('locale'),
            ));
        }

        return \View::make('catalog.search.index', [
            'albums' => $albums,
            'images' => $images,
            'categories' => $category,
            'result' => $query,
        ]);


    }

}