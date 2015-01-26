<?php

namespace Structure;

use \Input;
use \Lang;
use \Redirect;
use \Response;
use \Session;
use \URL;
use \View;

class MenusController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $itemsOnMenu = 15;

        $menus = Menu::with('translations')->orderBy('id')->paginate($itemsOnMenu);
        foreach ($menus as $menu) {
            $menu->title = '<a href="' . URL::Route('manager.structure.pages.index', ['id' => $menu->id]) . '">' . $menu->title . '</a>';
        }
        unset($itemsOnMenu);

        return View::make('structure.menus.index', [
            'entities' => $menus,
            'fields' => ['title', 'slug'],
            'actions' => ['show' => ['route' => 'manager.structure.pages.index'], 'edit'],
            'slug' => 'menu',
            'routeSlug' => 'structure.menus',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('manager.create', [
            'entity' => new Menu(),
            'slug' => 'menu',
            'routeSlug' => 'structure.menus',
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $menu = new Menu(Input::all());
        if (!$menu->save()) {
            return Redirect::back()->withInput()->withErrors($menu->getErrors());
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_created') .
            ' <a href="' . URL::Route('manager.structure.menus.edit', ['id' => $menu->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.structure.menus.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);

        return View::make('manager.edit', [
            'entity' => $menu,
            'slug' => 'menu',
            'routeSlug' => 'structure.menus',
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
        $menu = Menu::find($id);
        if (!$menu)
            return Response::view('errors.404', [], 404);

        if (!$menu->update(Input::all())) {
            return Redirect::back()->withInput()->withErrors($menu->getErrors());
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.structure.menus.edit', ['id' => $menu->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.structure.menus.index');
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
            $menu = Menu::find($id);
            if (!$menu)
                continue;
            foreach ($menu->pages as $page) {
                if ($page->is_home) {
                    Session::flash('manager_error_message', Lang::get('manager.messages.menu_containing_home_page_cant_be_removed'));
                    return Redirect::back();
                }
            }
            Menu::destroy($id);
        }
        Session::flash('manager_success_message', Lang::get('manager.messages.entities_deleted'));
        return Redirect::back();
    }


}
