<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ Lang::get('emails.feedback.new_message_header') }}</h2>

        <div>{{ Lang::get('emails.feedback.new_message_text') }}</div>

        <ul>
            <li>{{ Lang::get('emails.feedback.name') }}: {{{ $displayname }}}</li>
            <li>{{ Lang::get('emails.feedback.email') }}: {{{ $email }}}</li>
            <li>{{ Lang::get('emails.feedback.ip') }}: {{{ $ip }}}</li>
		</ul>

		<h5>{{{ $subject }}}</h5>

		<div>{{{ $text }}}</div>
	</body>
</html>
