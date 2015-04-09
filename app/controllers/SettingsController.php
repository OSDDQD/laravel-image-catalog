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

        return View::make('settings.index', [
            'textFields' => $textFields,
            'localizedFields' => $localizedFields,
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

        Session::flash('manager_success_message', Lang::get('manager.messages.entity_updated') .
            ' <a href="' . URL::Route('manager.settings.index') . '">' . Lang::get('buttons.edit') . '</a>');
        return Redirect::route('manager.settings.index');
	}


}