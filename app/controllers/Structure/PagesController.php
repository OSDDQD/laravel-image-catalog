<?php

namespace Structure;

use \App;
use \Component;
use \Input;
use \Material;
use \Lang;
use \Paginator;
use \Redirect;
use \Response;
use \Session;
use \URL;
use \View;

class PagesController extends \BaseController {

    public function home()
    {
        $page = Page::where('is_home', true)->limit(1)->first();
        if (!$page)
            return Response::view('errors.404', [], 404);

        return $this->display($page->slug);
    }

    public function display($slug)
    {
        $parameters = [];
        $page = Page::whereSlug($slug)->where('is_visible', true)->limit(1)->first();
        if (!$page)
            return Response::view('errors.404', [], 404);
        $parameters['page'] = $page;

        switch ($page->content_type) {
            case 'material':
                $material = Material::whereId($page->content)->whereIsVisible(true)->whereType('page')->first();
                if (!$material)
                    return Response::view('errors.404', [], 404);

                Paginator::setViewName('structure.pages.partials.pagination');

                // Components
                preg_match_all('/\[component id=\'(\w+)\'\]/', $material->text, $matches);
                foreach ($matches[0] as $index => $call) {
                    $call = str_replace('[', '\[', str_replace(']', '\]', $call));
                    $component = Component::whereName($matches[1][$index])->first();
                    if ($component) {
                        $cAction = $component->action;
                        $cParams = [];

                        $params = explode('|', $component->params);
                        if ($params) {
                            foreach ($params as $param) {
                                if (!$param)
                                    continue;
                                $param = explode(':', $param);
                                if (strpos($param[1], ',')) {
                                    $firstSymbol = mb_substr($param[1], 0, 1, 'UTF-8');
                                    if ($firstSymbol != '"' and $firstSymbol != "'")
                                        $param[1] = explode(',', $param[1]);
                                    unset($firstSymbol);
                                }
                                $cParams[$param[0]] = $param[1];
                            }
                            unset($param);
                        }
                        unset($params);
                    }

                    $material->text = preg_replace(
                        ['/<\w+>'.$call.'<\/\w+>/', '/'.$call.'/'],
                        App::make($component->controller)->$cAction((isset($cParams) ? array_merge(Input::all(), $cParams) : Input::all())),
                        $material->text
                    );
                    unset($cAction, $cParams);
                }

                // Modules
                preg_match_all('/\[module id=\'(\w+)\'\]/', $material->text, $matches);
                foreach ($matches[0] as $index => $call) {
                    $call = str_replace('[', '\[', str_replace(']', '\]', $call));
                    $module = 'modules.' . $matches[1][$index];

                    $material->text = preg_replace(['/<\w+>'.$call.'<\/\w+>/', '/'.$call.'/'], View::make($module), $material->text);
                }

                $parameters['material'] = $material;
                break;

        }

        switch($page->show_title) {
            case 'page':
                $parameters['pageTitle'] = $page->title;
                break;

            case 'material':
                $parameters['pageTitle'] = $parameters['material']->title;
                break;
        }

        if ($page->is_home) {
            $servicesMenu = Menu::whereSlug('services-menu')->first();
            if ($servicesMenu) {
                $parameters['servicesMenu'] = Page::with('translations')
                    ->whereMenuId($servicesMenu->id)
                    ->whereNull('parent_id')
                    ->whereIsVisible(true)
                    ->orderBy('position', 'ASC')
                    ->get();
                unset($servicesMenu);
            }

            $parameters['latestNews'] = Material::with('translations')
                ->where('type', '!=', Material::TYPE_PAGE)
                ->whereIsVisible(true)
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->get();
        }

        return View::make('structure.pages.display', $parameters);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $menu = Menu::find($id);
        if (!$menu)
            return Response::view('errors.404', [], 404);

        $pages = Page::with('translations')->whereMenuId($menu->id)->whereNull('parent_id')->orderBy('position')->get();

        return View::make('structure.pages.index', [
            'currentMenu' => $menu->id,
            'entities' => $pages,
            'fields' => ['title', 'content_type', 'is_visible', 'is_home', 'created_at', 'updated_at'],
            'langTranslations' => ['content_type' => 'fields.page.content_types'],
            'actions' => ['edit'],
            'slug' => 'page',
            'routeSlug' => 'structure.pages',
            'toolbar' => [
                ['label' => Lang::get('buttons.create'), 'class' => 'success', 'route' => 'manager.structure.pages.create', 'routeParams' => ['menuId' => $menu['id']]],
                ['label' => Lang::get('buttons.back_to_list'), 'class' => 'primary', 'route' => 'manager.structure.menus.index'],
            ],
            'headerSubtext' => '(' . Lang::choice('entities.menu.inf', 1) . ' "' . $menu->title . '")',
            'nested' => true,
            'fieldAsIndex' => 'position',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($menuId)
    {
        return View::make('manager.create', [
            'entity' => new Page(['menu_id' => $menuId]),
            'slug' => 'page',
            'routeSlug' => 'structure.pages',
            'indexRouteParams' => ['id' => $menuId],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $parentId = Input::get('parent_id');

        $page = new Page(Input::all());
        if (!$page->save()) {
            return Redirect::back()->withInput()->withErrors($page->getErrors());
        }

        if ($parentId)
            $page->setChildOf(Page::find($parentId));
        else
            $page->setAsRoot();

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_created') .
            ' <a href="' . URL::Route('manager.structure.pages.edit', ['id' => $page->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.structure.pages.index', ['id' => $page->menu_id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::find($id);

        return View::make('manager.edit', [
            'entity' => $page,
            'slug' => 'page',
            'routeSlug' => 'structure.pages',
            'indexRouteParams' => ['id' => $page->menu_id],
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $page = Page::find($id);
        if (!$page)
            return Response::view('errors.404', [], 404);

        if (!$page->update(Input::all())) {
            return Redirect::back()->withInput()->withErrors($page->getErrors());
        }

        $parentId = Input::get('parent_id');
        if ($parentId)
            $page->setChildOf(Page::find($parentId));
        else
            $page->setAsRoot();
        unset($parentId);

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.structure.pages.edit', ['id' => $page->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.structure.pages.index', ['id' => $page->menu_id]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
        $ids = Input::get('id');
        foreach ($ids as $id) {
            $page = Page::find($id);
            if (!$page)
                continue;
            if ($page->is_home) {
                Session::flash('manager_error_message', Lang::get('manager.messages.home_page_cant_be_removed'));
                return Redirect::back();
            }
            Page::destroy($id);
        }
        Session::flash('manager_success_message', Lang::get('manager.messages.entities_deleted'));
        return Redirect::back();
    }

}
