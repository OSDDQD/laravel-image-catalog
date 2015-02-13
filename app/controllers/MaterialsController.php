<?php

use \Roumen\Feed\Facades\Feed;
use \Structure\Page;

class MaterialsController extends \BaseController {

    public function news($input = [])
    {
        if (!$input)
            $input = Input::all();

        $limit = isset($input['limit']) ? (int) $input['limit'] : 0;
        $type  = isset($input['type']) ? strtolower($input['type']) : null;
        $template  = isset($input['template']) ? strtolower($input['template']) : 'materials.news';

        if(isset($input['mode'])) {
            switch($input['mode']) {
                case 'small':
                    $shortLimit = '150';
                    break;
                case 'medium':
                    $shortLimit = '300';
                    break;
                default:
                    $shortLimit = '500';
                    break;
            }
        }

        $query = Material::with('translations')
            ->whereIsVisible(true)
            ->orderBy('created_at', 'DESC');


        if (in_array($type, Material::getPossibleTypes()))
            $query->whereType($type);
        else
            $query->where('type', '!=', Material::TYPE_PAGE);

        $materials = $limit ? $query->limit($limit)->get() : $query->paginate(5);


        Paginator::setViewName('structure.pages.partials.pagination');

        return View::make($template, [
            'entities' => $materials,
            'textShorten' => isset($shortLimit) ? $shortLimit : 500,
        ]);
    }

    public function archive($type = null)
    {
        $itemsOnPage = 25;

        $possibleTypes = [
            'news',
            'additional',
            'announcement',
            'action',
        ];
        if (!in_array($type, $possibleTypes))
            return Response::view('errors.404', [], 404);

        $materials = Material::with('translations')
            ->whereIsVisible(true)
            ->whereType($type)
            ->orderBy('created_at', 'DESC')
            ->paginate($itemsOnPage);
        unset($itemsOnPage);


        Paginator::setViewName('structure.pages.partials.pagination');

        return View::make('materials.partials.archive', [
            'entities' => $materials,
        ]);
    }

    public function display($id, $type = 'news')
    {
        $material = Material::whereIsVisible(true)->whereId($id)->first();
        if (!$material)
            return Response::view('errors.404', [], 404);

        switch($type) {
            case Material::TYPE_NEWS:
                $backPage = Page::withComponent('news');
                break;

            case Material::TYPE_ACTION:
                $backPage = Page::withComponent('actions');
                break;

            case Material::TYPE_ANNOUNCEMENT:
                $backPage = Page::withComponent('announcements');
                break;
        }

        return View::make('materials.display', [
            'entities' => [$material],
            'backPage' => $backPage,
        ]);
    }

    public function rss($locale = null)
    {
        $allowedLocales = Config::get('app.locales');
        if (!$locale or !in_array($locale, $allowedLocales))
            $locale = $allowedLocales[0];
        App::setLocale($locale);

        $materials = Material::with('translations')->whereType('news')->orderBy('created_at', 'DESC')->limit(10)->get();

        $feed = Feed::make();

        $feed->title = Lang::get('client.rss.title');
        $feed->description = Lang::get('client.rss.description', ['sitename' => Config::get('app.site_title')]);
        $feed->link = URL::route('rss', ['locale' => App::getLocale()]);
        $feed->pubdate = $materials[0]->created_at;
        $feed->lang = App::getLocale();

        foreach ($materials as $material) {
            if (!$material->title or !$material->text)
                continue;

            $feed->add($material->title, Config::get('app.site_title'), '/news/' . $material->id, $material->created_at, '', '');
        }

        return $feed->render('rss', 0);
    }

	/**
	 * Display a listing of the resource.
	 *
     * @param  string|null $type
	 * @return Response
	 */
	public function index($type = null)
	{
        $possibleTypes = Material::getPossibleTypes(true);
        if (!array_key_exists($type, $possibleTypes))
            $type = null;

        $itemsOnPage = 15;
        $materials = $type ?
            Material::with('translations')->whereType($type)->orderBy('updated_at', 'DESC')->paginate($itemsOnPage) :
            Material::with('translations')->orderBy('updated_at', 'DESC')->paginate($itemsOnPage);
        unset($itemsOnPage);

		return View::make('materials.index', [
            'possibleTypes' => $possibleTypes,
            'currentType' => $type,
            'entities' => $materials,
            'fields' => ['title', 'type', 'is_visible', 'created_at', 'updated_at'],
            'langTranslations' => ['type' => 'fields.material.types'],
            'actions' => ['edit'],
            'slug' => 'material',
            'routeSlug' => 'materials',
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
            'entity' => new Material(),
            'slug' => 'material',
            'routeSlug' => 'materials',
        ]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $material = new Material(Input::all());

        if (!$material->save()) {
            return Redirect::back()->withInput()->withErrors($material->getErrors());
        }

        if (Input::file('image')) {
            if (!$material->uploadImage(Input::file('image'), 'image')) {
                $material->delete();
                return Redirect::back()->withInput()->withErrors($material->getErrors());
            }
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_created') .
            ' <a href="' . URL::Route('manager.materials.edit', ['id' => $material->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.materials.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $material = Material::find($id);

        return View::make('manager.edit', [
            'entity' => $material,
            'slug' => 'material',
            'routeSlug' => 'materials',
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
        $material = Material::find($id);

        if (!$material->update(Input::except('image'))) {
            return Redirect::back()->withInput()->withErrors($material->getErrors());
        }

        if (Input::file('image')) {
            if (!$material->uploadImage(Input::file('image'), 'image')) {
                return Redirect::back()->withInput()->withErrors($material->getErrors());
            }
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.materials.edit', ['id' => $material->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.materials.index');
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
            Material::destroy($id);
        }
        Session::flash('manager_success_message', Lang::get('manager.messages.entities_deleted'));
        return Redirect::back();
	}


}
