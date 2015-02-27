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
    // CLIENT SECTION ================================
    // ===============================================
    function addMenuItem($menu, $node, $nodeSlugAsClass = false, $parentNode = null)
    {
        $options = [];
        if ($node['content_type'] == \Structure\Page::CONTENT_TYPE_LINK) {
            $options['url'] = $node['content'];
        } else {
            $options['route'] = ['pages.display', 'slug' => $node['slug']];
        }
        if ($nodeSlugAsClass)
            $options['class'] = $node['slug'];

        if (!$parentNode) {
            $parentNode = $menu->add(
                ((isset($node['title']) and $node['title']) ? $node['title'] : $node['slug']),
                $options
            );
        } else {
            $parentNode = $menu->find($parentNode->id)->add(
                ((isset($node['title']) and $node['title']) ? $node['title'] : $node['slug']),
                $options
            );
        }

        foreach ($node['children'] as $childNode)
            addMenuItem($menu, $childNode, $nodeSlugAsClass, $parentNode);
    }

    $clientMenus = [
        'main-menu' => [
            'ClientMainMenu', false, null,
        ],
        'sidebar-menu' => [
            'ClientSidebarMenu', true, 1,
        ],
        'footer-menu' => [
            'ClientFooterMenu', false, 2,
        ],
    ];
    foreach($clientMenus as $menuSlug => $params) {
        if (!Menu::getCollection()->has($params[0])) {
            try {
                Menu::make($params[0], function ($menu) use ($menuSlug, $params) {
                    $tree = Structure\Page::getTreeStructure(['menuSlug' => $menuSlug]);
                    foreach ($tree as $node)
                        addMenuItem($menu, $node, $params[1]);
                });
            }
            catch (\Exception $e) {
                if (App::isLocal())
                    throw $e;
                continue;
            }
        }
    }
    unset($clientMenus);

    // ===============================================
    // MANAGER SECTION ===============================
    // ===============================================
    if (Auth::user()) {
        if (Auth::user()->hasRole('master-admin')) {
            Menu::make('ManagerSidebarMenu', function ($menu) {
                $menu->add('<i class="fa fa-fw fa-home"></i> ' . Lang::get('manager.menu.home'), ['route' => 'manager.home']);
                $menu->add('<i class="fa fa-fw fa-file-text"></i> ' . Lang::get('manager.menu.materials'), ['route' => 'manager.materials.index']);
                $menu->add('<i class="fa fa-fw fa-bars"></i> ' . Lang::get('manager.menu.structure'), ['route' => 'manager.structure.menus.index']);
                $menu->add('<i class="fa fa-fw fa-pie-chart"></i> ' . Lang::get('manager.menu.pizzas'), ['route' => 'manager.pizza.pizzas.index']);
                $menu->add('<i class="fa fa-fw fa-recycle"></i> ' . Lang::get('manager.menu.ingredients'), ['route' => 'manager.pizza.icategories.index']);
                $menu->add('<i class="fa fa-fw fa-tasks"></i> ' . Lang::get('manager.menu.menu'), ['route' => 'manager.menu.categories.index']);
                $menu->add('<i class="fa fa-fw fa-book"></i> ' . Lang::get('manager.menu.guestbook'), ['route' => 'manager.guestbook.index']);
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