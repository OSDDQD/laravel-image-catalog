<?php

class SettingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /settings
	 *
	 * @return Response
	 */
	public function index()
	{
        // Text fields
        $textFields = Setting::whereIsEditable(true)->whereType(Setting::TYPE_TEXT)->get();

        // Localized fields
        $localizedFields = [];
        $localized = Setting::whereIsEditable(true)->whereType(Setting::TYPE_LOCALIZED)->get();
        foreach($localized as $field) {
            if (!isset($localizedFields[$field->locale]))
                $localizedFields[$field->locale] = [];
            $localizedFields[$field->locale][] = $field;
        }

        // Serialized fields
        $topSlider = Setting::whereIsEditable(true)->whereName('top_slider')->first();
        $topSliderData = $topSlider ? unserialize($topSlider->value) : [];
        for ($i = 0; $i < count($topSliderData); $i++) {
            if (!$topSliderData[$i])
                continue;
            $topSliderData[$i] = new Slider\Image();
            $topSliderData[$i]->id = $i;
        }

        return View::make('settings.index', [
            'textFields' => $textFields,
            'localizedFields' => $localizedFields,
            'topSliderData' => $topSliderData,
            'slug' => 'setting',
            'routeSlug' => 'settings',
        ]);
	}


	/**
	 * Update resources in storage.
	 * PUT /settings
	 *
	 * @return Response
	 */
	public function update()
    {
        // Text settings
        $textFields = Setting::whereIsEditable(true)->whereType(Setting::TYPE_TEXT)->get();
        foreach($textFields as $textField) {
            if (!$textField->update(['value' => Input::get($textField->name)])) {
                $errors = current($textField->getErrors());
                return Redirect::back()->withInput()->withErrors([$textField->name => $errors['value']]);
            }
        }

        // Localized fields
        $localized = [];
        foreach (Config::get('app.locales') as $locale) {
            $localized[$locale] = Input::get($locale);
        }

        $localizedFields = Setting::whereIsEditable(true)->whereType(Setting::TYPE_LOCALIZED)->get();
        foreach ($localizedFields as $localizedField) {
            if (!$localizedField->update(['value' => $localized[$localizedField->locale][$localizedField->name]])) {
                $errors = current($localizedField->getErrors());
                return Redirect::back()->withInput()->withErrors([$localizedField->name => $errors['value']]);
            }
        }

        // Serialized fields
        $topSlider = Setting::whereIsEditable(true)->whereName('top_slider')->first();
        $topSliderData = $topSlider ? unserialize($topSlider->value) : [];

        $topSliderDelete = Input::exists('top_slider_delete') ? Input::get('top_slider_delete') : [];
        $topSliderFiles = Input::exists('top_slider') ? Input::file('top_slider') : [];

        $newTopSlider = [];
        for ($i = 0; $i < 5; $i++) {
            $topSliderImage = new Slider\Image();
            $topSliderImage->id = $i;

            if (array_key_exists($i, $topSliderDelete)) {
                $newTopSlider[$i] = $topSliderImage->removeImage() ? false : true;
            } elseif (isset($topSliderFiles[$i])) {
                $newTopSlider[$i] = $topSliderImage->uploadImage($topSliderFiles[$i]);
            } elseif (isset($topSliderData[$i])) {
                $newTopSlider[$i] = $topSliderData[$i];
            } else {
                $newTopSlider[$i] = false;
            }
        }

        $topSlider->update(['value' => serialize($newTopSlider)]);

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.settings.index') . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.settings.index');
	}


}