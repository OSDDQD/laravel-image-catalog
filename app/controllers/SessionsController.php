<?php

class SessionsController extends \BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('sessions.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

        foreach(['username' => User::makeSEOString($input['login']), 'email' => $input['login']] as $key => $value) {
            $attempt = Auth::attempt([
                $key => $value,
                'password' => $input['password'],
            ], isset($input['rememberme']) ? true : false);
            if ($attempt) {
                return Redirect::intended(URL::Route('home'));
            }
        }

        return Redirect::route('users.login')->withInput()->withErrors(new \Illuminate\Support\MessageBag([
            'userdata' => Lang::get('validation.custom.userdata.invalid'),
        ]));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();

        return Redirect::home();
	}


}
