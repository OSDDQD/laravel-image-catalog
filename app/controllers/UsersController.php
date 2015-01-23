<?php

class UsersController extends \BaseController {

    /**
     * Show the form for registering new User.
     *
     * @return Response
     */
    public function registration()
    {
        return View::make('users.registration', [
            'entity' => new User(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function register()
    {
        $input = Input::all();

        $rules = ['captcha' => ['required', 'captcha']];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors(new \Illuminate\Support\MessageBag([
                'captcha' => Lang::get('validation.custom.captcha.invalid')
            ]));
        }

        if ($input['password'] != $input['password_confirmation'])
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors(new \Illuminate\Support\MessageBag([
                'password' => Lang::get('validation.confirmed', ['attribute' => Lang::get('fields.password')])
            ]));

        $user = new User(Input::all());
        if (!$user->save()) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors($user->getErrors());
        }
        $user->addRole(Role::whereIsDefault(true)->first());

        Auth::attempt([
            'username' => $user->username,
            'password' => Input::get('password'),
        ]);

        return Redirect::back();
    }


    /**
     * Show the User's profile.
     *
     * @return Response
     */
    public function profile()
    {
        return View::make('users.profile', [
            'entity' => Auth::user(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function updateProfile()
    {
        $input = Input::all();

        $rules = ['captcha' => ['required', 'captcha']];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors(new \Illuminate\Support\MessageBag([
                'captcha' => Lang::get('validation.custom.captcha.invalid')
            ]));
        }

        $user = Auth::user();

        if ($input['password'] and $input['password'] != $input['password_confirmation']) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors(new \Illuminate\Support\MessageBag([
                'password' => Lang::get('validation.confirmed', ['attribute' => Lang::get('fields.password')])
            ]));
        } else {
            $user->password = $input['password'];
        }

        $user->birthday = Input::get('birthday');
        $user->displayname = Input::get('displayname');
        $user->email = Input::get('email');
        $user->is_female = Input::get('is_female');

        if (!$user->save()) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors($user->getErrors());
        }

        return Redirect::back();
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = User::paginate(15);

        return View::make('manager.index', [
            'entities' => $users,
            'fields' => ['displayname', 'roles->name', 'created_at', 'updated_at'],
            'langTranslations' => ['roles' => 'roles'],
            'actions' => ['edit'],
            'slug' => 'user',
            'routeSlug' => 'users',
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
            'entity' => new User(),
            'slug' => 'user',
            'routeSlug' => 'users',
        ]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $user = new User(Input::all());

        if (!$user->save()) {
            return Redirect::back()->withInput()->withErrors($user->getErrors());
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_created') .
            ' <a href="' . URL::Route('manager.users.edit', ['id' => $user->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.users.index');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = User::find($id);

        return View::make('manager.edit', [
            'entity' => $user,
            'slug' => 'user',
            'routeSlug' => 'users',
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
        $user = User::find($id);

        if (!$user->update(Input::all())) {
            return Redirect::back()->withInput()->withErrors($user->getErrors());
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.users.edit', ['id' => $user->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.users.index');
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
            User::destroy($id);
        }
        Session::flash('manager_success_message', Lang::get('manager.messages.entities_deleted'));
        return Redirect::back();
	}


}
