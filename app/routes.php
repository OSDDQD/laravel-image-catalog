<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// ===============================================
// GLOBAL SECTION ================================
// ===============================================

Route::get('language/{locale}', [
    'as' => 'language',
    function($locale) {
        if (!in_array($locale, Config::get('app.locales')))
            return;

        Session::set('locale', $locale);
        if (Request::header('referer'))
            return Redirect::back();
        return Redirect::route('home');
    }
]);

$locale = Session::get('locale');
if ($locale and in_array($locale, Config::get('app.locales')))
    App::setLocale($locale);

// ===============================================
// CLIENT SECTION ================================
// ===============================================

// Home
Route::get('/', [
    'as' => 'home',
    'uses' => 'Catalog\Category@index',
]);

// Preview
Route::get('preview/managed/{object}/{mode}-{format}-{file}', [
    'as' => 'preview.managed',
    'uses' => 'PreviewController@managed'
]);
Route::get('preview/{object}-{id}-{mode}.{format}', [
    'as' => 'preview.uploaded',
    'uses' => 'PreviewController@uploaded'
]);

// RSS
Route::get('rss/{locale?}', [
    'as' => 'rss',
    'uses' => 'MaterialsController@rss'
]);

// Search
Route::get('/search/{where?}', [
    'as' => 'search',
    'uses' => 'SearchController@search',
]);

// Users
Route::get('login', [
    'as' => 'users.login',
    'uses' => 'SessionsController@create',
])->before('guest');
Route::get('logout', [
    'as' => 'users.logout',
    'uses' => 'SessionsController@destroy',
])->before('auth');
    Route::get('register', [
        'as' => 'users.registration',
        'uses' => 'UsersController@registration',
    ])->before('guest');
    Route::post('register', [
        'as' => 'users.register',
        'uses' => 'UsersController@register',
    ])->before('guest');
    Route::get('profile', [
        'as' => 'users.profile',
        'uses' => 'UsersController@profile',
    ])->before('auth');
    Route::post('profile', [
        'as' => 'users.update',
        'uses' => 'UsersController@updateProfile',
    ])->before('auth');
Route::get('password/reset', [
    'as' => 'password.remind',
    'uses' => 'RemindersController@getRemind',
]);
Route::post('password/reset', [
    'as' => 'password.request',
    'uses' => 'RemindersController@postRemind',
]);
Route::get('password/reset/{token}', [
    'as' => 'password.reset',
    'uses' => 'RemindersController@getReset',
]);
Route::post('password/reset/{token}', [
    'as' => 'password.update',
    'uses' => 'RemindersController@postReset',
]);
Route::resource('sessions', 'SessionsController', ['only' => ['store', 'destroy']]);

// Feedback
Route::post('feedback/send', [
    'as' => 'feedback.send',
    'uses' => 'FeedbackController@send',
]);

// ===============================================
// MANAGER SECTION ===============================
// ===============================================

Route::group(['prefix' => 'manager', 'before' => 'roles:master-admin'], function()
{
    // Home
    Route::get('/', [
        'as' => 'manager.home',
        'uses' => 'HomeController@manager',
    ]);

    // Catalog
    Route::group(['prefix' => 'catalog', 'namespace' => 'Catalog'], function() {

        // Catalog Categories
        Route::resource('categories', 'CategoryController', ['except' => ['show', 'destroy']]);
        Route::delete('categories/destroy', [
            'as' => 'manager.catalog.categories.destroy',
            'uses' => 'CategoryController@destroy'
        ]);

        // Albums
        Route::resource('albums', 'AlbumController', ['except' => ['index', 'create', 'show', 'destroy']]);
        Route::get('categories/{id}/albums', [
            'as' => 'manager.catalog.albums.index',
            'uses' => 'AlbumController@index',
        ]);
        Route::get('categories/{categoryId}/albums/create', [
            'as' => 'manager.catalog.album.create',
            'uses' => 'AlbumController@create'
        ])->where(['categoryId' => '\d+']);
        Route::delete('albums/destroy', [
            'as' => 'manager.catalog.albums.destroy',
            'uses' => 'AlbumController@destroy'
        ]);

        //Images
        Route::resource('images', 'ImageController', ['except' => ['index', 'create', 'show', 'destroy']]);
        Route::get('albums/{id}/images', [
            'as' => 'manager.catalog.images.index',
            'uses' => 'ImageController@index',
        ]);
        Route::get('albums/{albumId}/images/create', [
            'as' => 'manager.catalog.image.create',
            'uses' => 'ImageController@create'
        ])->where(['albumId' => '\d+']);
        Route::delete('images/destroy', [
            'as' => 'manager.catalog.images.destroy',
            'uses' => 'ImageController@destroy'
        ]);

    });

    // Users
    Route::resource('users', 'UsersController', ['except' => ['destroy']]);
    Route::delete('users/destroy', [
        'as' => 'manager.users.destroy',
        'uses' => 'UsersController@destroy'
    ]);

    // Settings
    Route::get('settings', [
        'as' => 'manager.settings.index',
        'uses' => 'SettingsController@index',
    ]);
    Route::put('settings', [
        'as' => 'manager.settings.update',
        'uses' => 'SettingsController@update'
    ]);

    // Finder
    Route::get('elfinder', [
        'as' => 'elfinder_open',
        'uses' => 'Barryvdh\Elfinder\ElfinderController@showIndex'
    ]);
    Route::any('elfinder/connector', [
        'as' => 'elfinder_connect',
        'uses' => 'Barryvdh\Elfinder\ElfinderController@showConnector'
    ]);
    Route::get('elfinder/tinymce', [
        'as' => 'elfinder_tinymce',
        'uses' => 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4'
    ]);
});


/*
|--------------------------------------------------------------------------
| Generate required menus
|--------------------------------------------------------------------------
|
|
*/

require app_path().'/globals.php';
require app_path().'/menus.php';