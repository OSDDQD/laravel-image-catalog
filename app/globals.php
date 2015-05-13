<?php

// Settings
try {
    $settings = Setting::all();
    foreach ($settings as $setting) {
        switch ($setting->name) {
            case 'facebook':
            case 'twitter':
            case 'odnoklassniki':
	        case 'google':
            case 'vkontakte':
            case 'instagram':
                View::share('social' . ucfirst($setting->name) . 'Url', $setting->value);
                break;

            case 'unescourl':
                View::share(ucfirst($setting->name), $setting->value);
                break;

            case 'address':
            case 'schedule':
                if ($setting->locale == App::getLocale())
                    View::share('footer' . ucfirst($setting->name), $setting->value);
                break;

            case 'phones':
                View::share('footer' . ucfirst($setting->name), explode(',', $setting->value));
                break;
        }
    }
    unset($setting, $settings);
}
catch (\Exception $e) {}