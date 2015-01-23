<?php

use Structure\Page;

class SearchController extends BaseController
{

    public function search($where = null)
    {
        $scopes = [
            'pages',
            'news',
            'actions',
            'announcements',
        ];

        $where = strtolower($where);
        if (!$where or !in_array($where, $scopes))
            $where = $scopes[0];

        $query = Input::get('q');
        if (!$query)
            return View::make('search.search', [
                'query' => $query,
                'results' => [],
                'scopes' => $scopes,
                'where' => $where,
            ]);

        switch ($where) {
            case 'pages':
                $results = Page::search($query, 10);
                break;

            case 'news':
                $results = Material::search(Material::TYPE_NEWS, $query, 10);
                break;

            case 'actions':
                $results = Material::search(Material::TYPE_ACTION, $query, 10);
                break;

            case 'announcements':
                $results = Material::search(Material::TYPE_ANNOUNCEMENT, $query, 10);
                break;
        }

        Paginator::setViewName('structure.pages.partials.pagination');

        return View::make('search.search', [
            'query' => $query,
            'results' => isset($results) ? $results : [],
            'scopes' => $scopes,
            'where' => $where,
        ]);
    }

}