<?php

class HomeController extends BaseController {

	public function welcome()
	{
        $homePage = Page::where('is_home', true)->limit(1)->first();

		return View::make('welcome', [
            'homePage' => $homePage
        ]);
	}

    public function manager()
    {
        // Server information
        $serverInfo = [
            [
                'label' => Lang::get('manager.dashboard.server_info.os'),
                'icon' => 'desktop',
                'value' => PHP_OS,
            ], [
                'label' => Lang::get('manager.dashboard.server_info.web_server'),
                'icon' => 'gear',
                'value' => Request::server('SERVER_SOFTWARE'),
            ], [
                'label' => Lang::get('manager.dashboard.server_info.php_version'),
                'icon' => 'archive',
                'value' => phpversion(),
            ], [
                'label' => Lang::get('manager.dashboard.server_info.mysql_version'),
                'icon' => 'database',
                'value' => DB::getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION),
            ],

        ];

        // Directories access
        $dirs = [
            Config::get('app.uploads_root') . '/catalog' => [
                'label' => '/catalog',
                'status' => [],
            ],
            Config::get('app.uploads_root') . '/incoming' => [
                'label' => '/incoming',
                'status' => [],
            ],
        ];

        foreach ($dirs as $path => &$params) {
            $dir = new \SplFileInfo($path);
            if (!$dir->isDir())
                $params['status'] = ['class' => 'danger', 'message' => 'not_exists'];
            elseif (!$dir->isReadable())
                $params['status'] = ['class' => 'danger', 'message' => 'not_readable'];
            elseif (!$dir->isWritable())
                $params['status'] = ['class' => 'danger', 'message' => 'not_writable'];
            else
                $params['status'] = ['class' => 'success', 'message' => 'ok'];
            $params['status']['message'] = Lang::get('manager.dashboard.directories_access.status.' . $params['status']['message']);
        }

        return View::make('manager.home', [
            'serverInfo' => $serverInfo,
            'dirs' => $dirs,
        ]);
    }

}
