<?php

/*
|--------------------------------------------------------------------------
| Application Menus
|--------------------------------------------------------------------------
|
| Here is where you can register all of the menus for an application.
|
*/

try {
    // ===============================================
    // MANAGER SECTION ===============================
    // ===============================================
    if (Auth::user()) {
        if (Auth::user()->hasRole('master-admin')) {
            Menu::make('ManagerSidebarMenu', function ($menu) {
                $menu->add('<i class="fa fa-fw fa-home"></i> ' . Lang::get('manager.menu.home'), ['route' => 'manager.home']);
                $menu->add('<i class="fa fa-fw fa-book"></i> ' . Lang::get('manager.menu.catalog'), ['route' => 'manager.catalog.categories.index']);
                $menu->add('<i class="fa fa-fw fa-users"></i> ' . Lang::get('manager.menu.users'), ['route' => 'manager.users.index']);
                $menu->add('<i class="fa fa-fw fa-cogs"></i> ' . Lang::get('manager.menu.settings'), ['route' => 'manager.settings.index']);
                $menu->add('<i class="fa fa-fw fa-sitemap"></i> ' . Lang::get('manager.menu.site'), ['route' => 'home']);
                $menu->add('<i class="fa fa-fw fa-sign-out"></i> ' . Lang::get('manager.menu.logout'), ['route' => 'users.logout']);
            });
        }
        elseif (Auth::user()->hasRole('user')) {
            Menu::make('ManagerSidebarMenu', function ($menu) {
                $menu->add('<i class="fa fa-fw fa-dashboard"></i> ' . Lang::get('manager.menu.home'), ['route' => 'manager.home']);
            });
        }
    }
}
catch (\Exception $e) {
//    if (App::isLocal())
//        throw $e;
}