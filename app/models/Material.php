<?php

use \Basic\TranslatableTrait;
use \Basic\UploadableInterface;
use \Basic\UploadableTrait;

class Material extends BaseModel implements UploadableInterface
{

    use TranslatableTrait,
        UploadableTrait;

    const TYPE_ACTION = 'action';
    const TYPE_ANNOUNCEMENT = 'announcement';
    const TYPE_NEWS = 'news';
    const TYPE_PAGE = 'page';
    const TYPE_ADDITIONAL = 'additional';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'is_visible', 'title', 'text'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'text'];

    protected static $rules = [];

    /**
     * Adds observer inheritance
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function(Material $entity) {
            $entity->removeImage('image');
        });
    }

    /**
     * Returns directory name where uploaded files are stored.
     * Starting slash should be included.
     *
     * @return string
     */
    public static function getUploadDir()
    {
        return '/materials';
    }

    /**
     * Returns path to directory where uploaded files are stored.
     * Usually it returns Config::get('app.uploads_root').self::getUploadDir()
     *
     * @return string
     */
    public static function getUploadPath()
    {
        return Config::get('app.uploads_root').self::getUploadDir();
    }

    /**
     * Returns slug used to name uploaded files like 'slug-id.ext'
     *
     * @return string
     */
    public static function getUploadSlug()
    {
        return 'material';
    }

    public static function search($type, $str, $itemsOnPage = 0)
    {
        $ids = [];
        $translations = MaterialTranslation::select('material_id')
            ->whereLocale(App::getLocale())
            ->where(function($query) use ($str) {
                $query->where('title', 'LIKE', "%$str%")->orWhere('text', 'LIKE', "%$str%");
            })->get();
        foreach($translations as $translation) {
            $ids[] = $translation->material_id;
        }

        if (!$ids)
            return false;
        $sql = self::whereType(in_array($type, self::getPossibleTypes()) ? $type : self::TYPE_PAGE)
            ->whereIsVisible(true)
            ->whereIn('id', $ids);

        $materials = $itemsOnPage ? $sql->paginate((int) $itemsOnPage) : $sql->get();
        foreach($materials as $material) {
            $material->text = preg_replace('/\[\w+ id=\'\w+\'\]/', '', strip_tags($material->text));
        }

        return $materials;
    }

    public static function getPossibleMaterials()
    {
        $table = with(new static)->getTable();
        $translationsTable = $table . '_translations';

        return DB::table($table)
            ->select(["$table.id", "$translationsTable.title"])
            ->join($translationsTable, "$table.id", '=', "$translationsTable.material_id")
            ->whereLocale(App::getLocale())
            ->whereType('page')
            ->lists('title', 'id');
    }

    public static function getPossibleTypes($withLabels = false)
    {
        $table = with(new static)->getTable();
        $type = DB::select(DB::raw("SHOW COLUMNS FROM " .$table . " WHERE Field = 'type'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }
        if ($withLabels) {
            $labeledEnum = [];
            foreach ($enum as $value) {
                $labeledEnum[$value] = Lang::get('fields.material.types.' . $value);
            }
            unset($enum);
            return $labeledEnum;
        }
        return $enum;
    }

}