<?php

class FeedbackController extends \BaseController {

	public function form()
	{
        return View::make('feedback.form');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function send()
	{
        $data = Input::all();

        $rules = [
            'displayname' => ['required'],
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'text' => ['required', ['max' => 500]],
        ];
        if (Auth::getUser()) {
            $data['displayname'] = Auth::user()->displayname;
            $data['email'] = Auth::user()->email;
        } else {
            $rules['captcha'] = ['required', 'captcha'];
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::except('captcha'))->withErrors($validator->errors());
        }

        $data['ip'] = Request::getClientIp();

        $feedbackEmails = Setting::whereName('feedback_emails')->first();
        if ($feedbackEmails) {
//            if (!
            Mail::send('emails.feedback.message', $data, function ($message) use ($feedbackEmails) {
                $message->subject(Lang::get('emails.feedback._new_message_subject'));
                $message->from('noreply@' . Request::server('HTTP_HOST'), 'Feedback service');
                foreach (explode(',', $feedbackEmails['value']) as $feedbackEmail)
                    $message->to($feedbackEmail);
            });
//            ) {
//                Session::flash('feedback_message', Lang::get('client.mail_send_error'));
//                return Redirect::back()->withInput(Input::except('captcha'));
//            }

        }

        Session::flash('feedback_message', Lang::get('client.feedback_message_sent'));
        return Redirect::back();
	}


}
