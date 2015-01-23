<?php

namespace Basic;

trait SelectableTrait
{

    public static function scanIncoming(array $options = [], &$files = [], $relatedDir = null)
    {
        $dir = isset($options['dir']) ? $options['dir'] : \Config::get('app.incoming_root');
        $isRecursive = isset($options['recursive']) ? (bool) $options['recursive'] : true;
        $filters = isset($options['filters']) ? $options['filters'] : [];

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item == '..' or $item == '.')
                continue;
            $item = new \SplFileInfo($dir.'/'.$item);
            if ($item->isDir()) {
                if ($isRecursive)
                    self::scanIncoming(array_merge($options, ['dir' => $item]), $files, (implode('/', [$relatedDir, $item->getFilename()])));
            }
            elseif ($item->isFile()) {
                if ($filters) {
                    if (isset($filters['extension'])) {
                        if (!in_array($item->getExtension(), $filters['extension']))
                            continue;
                    }
                }
                $files[] = [
                    'fullPath' => $item->getPath(),
                    'relativePath' => $relatedDir,
                    'name' => $item->getFilename(),
                    'isReadable' => $item->isReadable(),
                    'isWritable' => $item->isWritable(),
                ];
            }
        }

        return $files;
    }

    public static function getIncomingList(array $options = [])
    {
        $files = self::scanIncoming($options);

        $list = [];
        $disabled = [];
        foreach($files as $file) {
            $key = implode('/', [$file['fullPath'], $file['name']]);

            $list[$key] = implode('/', [$file['relativePath'], $file['name']]);
            if (!$file['isReadable'] or !$file['isWritable'])
                $disabled[] = $key;
        }

        return ['list' => $list, 'disabled' => $disabled];
    }

}