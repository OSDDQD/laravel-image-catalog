<?php

namespace Basic;

trait PositionedTrait
{

    public static function getByParentList($options = [])
    {
        if (!isset($options['parentField']))
            throw new \Exception('PositionedTrait::getByParentList requires parentField to be provided');

        $parentField = $options['parentField'];
        $list = [];

        if (!isset($options['translations']) or !$options['translations'])
            $query = self::orderBy('position');
        else
            $query = self::with('translations')->orderBy('position');

        if (isset($options['where'])) {
            foreach ($options['where'] as $field => $value) {
                $query->where($field, $value);
            }
        }

        $entities = $query->get();

        foreach ($entities as $entity) {
            $parentId = (int) $entity->$parentField;
            if (!isset($list[$parentId]))
                $list[$parentId] = [];
            $list[$parentId][] = $entity->title;
        }
        return $list;
    }

}