<?php

use Guestbook\Message;

class GuestbookController extends \BaseController {

    public function display()
    {
        $messages = \Guestbook\Message::whereIsVisible(true)->orderBy('created_at', 'DESC')->paginate(15);

        return View::make('guestbook.display', [
            'entities' => $messages,
            'pageTitle' => Lang::get('components.reviews._title'),
        ]);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $messages = Message::paginate(15);

        return View::make('manager.index', [
            'entities' => $messages,
            'fields' => [
                ['displayname', ['sanitize' => true]],
                ['text', ['sanitize' => true]],
                'ip',
                'is_visible',
                'created_at',
            ],
            'toolbar' => [],
            'actions' => ['edit'],
            'slug' => 'guestbook.message',
            'routeSlug' => 'guestbook',
        ]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Input::all();

        $message = new Message($input);
        $message->ip = Request::getClientIp();

        if (Auth::getUser()) {
            $message->user_id = Auth::getUser()->id;
            $message->displayname = Auth::getUser()->displayname;
        } else {
            $message->user_id = null;

            $rules = ['captcha' => ['required', 'captcha']];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput(Input::except('captcha'))->withErrors(new \Illuminate\Support\MessageBag([
                    'captcha' => Lang::get('validation.custom.captcha.invalid')
                ]));
            }
        }

        if (!$message->save()) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors($message->getErrors());
        }

        Session::flash('guestbook_message', Lang::get('client.guestbook_message_added'));
        return Redirect::back();
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $message = Message::find($id);

        return View::make('manager.edit', [
            'entity' => $message,
            'slug' => 'guestbook.message',
            'routeSlug' => 'guestbook',
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
        $message = Message::find($id);

        if (!$message->update(Input::only(['is_visible', 'text']))) {
            return Redirect::back()->withInput()->withErrors($message->getErrors());
        }

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.guestbook.edit', ['id' => $message->id]) . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.guestbook.index');
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
            Message::destroy($id);
        }
        Session::flash('manager_success_message', Lang::get('manager.messages.entities_deleted'));
        return Redirect::back();
	}


}
