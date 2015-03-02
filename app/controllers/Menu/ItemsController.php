<?php

namespace Menu;

class ItemsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return \Response
     */
    public function index($id)
    {
        $category = Category::find($id);
        if (!$category)
            return \Response::view('errors.404', [], 404);

        $itemsOnMenu = 15;

        $items = Item::with('translations')->whereCategoryId($category->id)->orderBy('position')->paginate($itemsOnMenu);
        foreach ($items as $item) {
            $item->title = '<a href="' . \URL::Route('manager.menu.items.edit', ['id' => $item->id]) . '">' . $item->title . '</a>';
        }
        unset($itemsOnMenu);

        return \View::make('manager.index', [
            'entities' => $items,
            'fields' => ['title', 'is_visible'],
            'actions' => ['edit'],
            'slug' => 'menu_items',
            'routeSlug' => 'menu.items',
            'toolbar' => [
                ['label' => \Lang::get('buttons.create'), 'class' => 'success', 'route' => 'manager.menu.items.create', 'routeParams' => ['categoryId' => $category['id']]],
                ['label' => \Lang::get('buttons.back_to_list'), 'class' => 'primary', 'route' => 'manager.menu.categories.index'],
            ],
            'headerSubtext' => '(' . \Lang::choice('entities.category.inf', 1) . ' "' . $category->title . '")',
            'fieldAsIndex' => 'position',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create($categoryId)
    {
        if (!$options = \Input::get('options'))
            $options = [];

        return \View::make('manager.create', [
            'entity' => new Item(['category_id' => $categoryId]),
            'slug' => 'menu_items',
            'routeSlug' => 'menu.items',
            'indexRouteParams' => ['id' => $categoryId],
            'options' => $options,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Response
     */
    public function store()
    {
        $item = new Item(\Input::all());
        if (!$item->save()) {
            return \Redirect::back()->withInput()->withErrors($item->getErrors());
        }

        if (\Input::file('image')) {
            if (!$item->uploadImage(\Input::file('image'), 'image')) {
                $item->delete();
                return \Redirect::back()->withInput()->withErrors($item->getErrors());
            }
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_created') .
            ' <a href="' . \URL::Route('manager.menu.items.edit', ['id' => $item->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.menu.items.index', ['id' => $item->category_id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Response
     */
    public function edit($id)
    {
        $item = Item::find($id);

        return \View::make('manager.edit', [
            'entity' => $item,
            'slug' => 'menu_items',
            'routeSlug' => 'menu.items',
            'indexRouteParams' => ['id' => $item->category_id],
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Response
     */
    public function update($id)
    {
        $item = Item::find($id);

        if (!$item)
            return \Response::View('errors.404', [], 404);

        if (!$item->update(\Input::except(['image_delete', 'image']))) {
            return \Redirect::back()->withInput()->withErrors($item->getErrors());
        }

        $imageDelete = \Input::exists('image_delete') ? \Input::get('image_delete') : false;
        $imageFile = \Input::exists('image') ? \Input::file('image') : false;

        if ($imageDelete) {
            $item->removeImage('image');
        } elseif ($imageFile) {
            $item->uploadImage($imageFile, 'image');
        } elseif (!$item->uploadImage($imageFile, 'image')) {
            return \Redirect::back()->withInput()->withErrors($item->getErrors());
        }

        \Session::flash('manager_success_message', \Lang::get('manager.messages.entity_updated') .
            ' <a href="' . \URL::Route('manager.menu.items.edit', ['id' => $item->id]) . '">' . \Lang::get('buttons.edit') . '</a>');
        return \Redirect::route('manager.menu.items.index', ['id' => $item->category_id]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Response
     */
    public function destroy()
    {
        $ids = \Input::get('id');
        foreach ($ids as $id) {
            $item = Item::find($id);
            if (!$item)
                continue;
            Item::destroy($id);
        }
        \Session::flash('manager_success_message', \Lang::get('manager.messages.entities_deleted'));
        return \Redirect::back();
    }


}
