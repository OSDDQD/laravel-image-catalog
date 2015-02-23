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
    'uses' => 'Structure\PagesController@home',
]);

// Preview
Route::get('preview/managed/{object}/{mode}-{format}-{file}', [
    'as' => 'preview.managed',
    'uses' => 'PreviewController@managed'
]);
//Route::get('preview/{object}-{id}-{mode}.{format}', [
//    'as' => 'preview.uploaded',
//    'uses' => 'PreviewController@uploaded'
//]);

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

// Pages
Route::get('pages/display/{slug}', [
    'as' => 'pages.display',
    'uses' => 'Structure\PagesController@display',
]);

// Archive
Route::get('archive/{type}', [
    'as' => 'archive',
    'uses' => 'MaterialsController@archive',
]);

// Materials
Route::get('news/display/{id}', [
    'as' => 'materials.news.display',
    'uses' => 'MaterialsController@display'
]);

// Guestbook
Route::resource('guestbook', 'GuestbookController', ['only' => ['store']]);

// Feedback
Route::post('feedback/send', [
    'as' => 'feedback.send',
    'uses' => 'FeedbackController@send',
]);


// Speedtest
Route::get('speed', [
    'as' => 'speedtest',
    function() {
        return View::make('pages.speedtest');
    }
]);

// Pizza Constructor
Route::get('constructor', [
    'as' => 'pizza.constructor',
    'uses' => 'Pizza\ConstructorController@index',
]);
Route::get('constructor/menu', [
    'as' => 'pizza.constructor.menu',
    'uses' => 'Pizza\ConstructorController@menu',
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

    // Materials
    Route::resource('materials', 'MaterialsController', ['except' => ['index', 'show', 'destroy']]);
    Route::get('materials/{type?}', [
        'as' => 'manager.materials.index',
        'uses' => 'MaterialsController@index'
    ]);
    Route::delete('materials/destroy', [
        'as' => 'manager.materials.destroy',
        'uses' => 'MaterialsController@destroy'
    ]);

    // Structure
    Route::group(['prefix' => 'structure', 'namespace' => 'Structure'], function() {
        // Menu
        Route::resource('menus', 'MenusController', ['except' => ['show', 'destroy']]);
        Route::delete('menus/destroy', [
            'as' => 'manager.structure.menus.destroy',
            'uses' => 'MenusController@destroy'
        ]);

        // Pages
        Route::resource('pages', 'PagesController', ['except' => ['index', 'create', 'show', 'destroy']]);
        Route::get('menus/{id}/pages', [
            'as' => 'manager.structure.pages.index',
            'uses' => 'PagesController@index',
        ]);
        Route::get('menus/{menuId}/pages/create', [
            'as' => 'manager.structure.pages.create',
            'uses' => 'PagesController@create'
        ])->where(['menuId' => '\d+']);
        Route::delete('pages/destroy', [
            'as' => 'manager.structure.pages.destroy',
            'uses' => 'PagesController@destroy'
        ]);
    });

    // Pizza
    Route::group(['prefix' => 'pizza', 'namespace' => 'Pizza'], function() {
        // Pizzas
        Route::resource('pizzas', 'PizzasController', ['except' => ['show', 'destroy']]);
        Route::delete('pizzas/destroy', [
            'as' => 'manager.pizza.pizzas.destroy',
            'uses' => 'PizzasController@destroy'
        ]);

        // Ingredients Categories
        Route::resource('icategories', 'IngredientsCategoriesController', ['except' => ['show', 'destroy']]);
        Route::delete('icategories/destroy', [
            'as' => 'manager.pizza.icategories.destroy',
            'uses' => 'IngredientsCategoriesController@destroy'
        ]);

        // Ingredients
        Route::resource('ingredients', 'IngredientsController', ['except' => ['index', 'create', 'show', 'destroy']]);
        Route::get('icategories/{id}/ingredients', [
            'as' => 'manager.pizza.ingredients.index',
            'uses' => 'IngredientsController@index',
        ]);
        Route::get('icategories/{categoryId}/ingredients/create', [
            'as' => 'manager.pizza.ingredients.create',
            'uses' => 'IngredientsController@create'
        ])->where(['categoryId' => '\d+']);
        Route::delete('ingredients/destroy', [
            'as' => 'manager.pizza.ingredients.destroy',
            'uses' => 'IngredientsController@destroy'
        ]);

    });


    // Guestbook
    Route::resource('guestbook', 'GuestbookController', ['only' => ['index', 'edit', 'update']]);
    Route::delete('guestbook/destroy', [
        'as' => 'manager.guestbook.destroy',
        'uses' => 'GuestbookController@destroy'
    ]);

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

    // Editor
    Route::post('editor/components', [
        'as' => 'manager.editor.components',
        'uses' => 'EditorController@components'
    ]);
    Route::post('editor/modules', [
        'as' => 'manager.editor.modules',
        'uses' => 'EditorController@modules'
    ]);
    Route::post('editor/galleryalbums', [
        'as' => 'manager.editor.galleryalbums',
        'uses' => 'EditorController@galleryalbums'
    ]);
    Route::post('editor/galleryphotos', [
        'as' => 'manager.editor.galleryphotos',
        'uses' => 'EditorController@galleryphotos'
    ]);
    Route::post('editor/videoalbums', [
        'as' => 'manager.editor.videoalbums',
        'uses' => 'EditorController@videoalbums'
    ]);
    Route::post('editor/videoclips', [
        'as' => 'manager.editor.videoclips',
        'uses' => 'EditorController@videoclips'
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