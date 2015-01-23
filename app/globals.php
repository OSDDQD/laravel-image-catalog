<?php

// Settings
try {
    $settings = Setting::all();
    foreach ($settings as $setting) {
        switch ($setting->name) {
            case 'facebook':
            case 'twitter':
            case 'odnoklassniki':
            case 'vkontakte':
                View::share('social' . ucfirst($setting->name) . 'Url', $setting->value);
                break;

            case 'address':
            case 'schedule':
                if ($setting->locale == App::getLocale())
                    View::share('footer' . ucfirst($setting->name), $setting->value);
                break;

            case 'phones':
                View::share('footer' . ucfirst($setting->name), explode(',', $setting->value));
                break;

            case 'top_slider':
                $topSlider = @unserialize($setting->value) or [];
                $topSliderData = [];
                foreach($topSlider as $i => $sliderImage) {
                    if (!$sliderImage)
                        continue;
                    $sliderImage = new Slider\Image();
                    $sliderImage->id = $i;
                    if (file_exists($sliderImage->getUploadPath() . '/' . $sliderImage->getUploadedFilename('jpg')))
                        $topSliderData[] = $sliderImage->getUploadedFilename('jpg');
                    unset($sliderImage);
                }
                unset($topSlider);
                View::share('topSliderData', $topSliderData);
                break;
        }
    }
    unset($setting, $settings);
}
catch (\Exception $e) {}

// Currency
try {
    if(file_exists(app_path() . '/data/currency.json')) {
        $currencies = json_decode(file_get_contents(app_path() . '/data/currency.json'), true);
        if ($currencies)
            View::share('currencies', $currencies);
        unset($currencies);
    }
}
catch (\Exception $e) {}