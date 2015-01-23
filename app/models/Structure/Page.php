<?php

namespace Structure;

use \App;
use \DB;
use \Lang;
use \Material;
use \MaterialTranslation;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use \Validator;
use \Basic\PositionedTrait;
use \Basic\TranslatableTrait;
use \Cviebrock\EloquentSluggable\SluggableInterface;
use \EloquentSluggable\SluggableTrait;
use \Gzero\EloquentTree\Model\Tree;

class Page extends Tree implements SluggableInterface
{

    use TranslatableTrait,
        SluggableTrait,
        PositionedTrait;

    const CONTENT_TYPE_HTML = 'html';
    const CONTENT_TYPE_LINK = 'link';
    const CONTENT_TYPE_MATERIAL = 'material';

    const SHOW_TITLE_MATERIAL = 'material';
    const SHOW_TITLE_NONE = 'none';
    const SHOW_TITLE_PAGE = 'page';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_id', 'parent_id', 'position', 'slug', 'show_title', 'content_type', 'content', 'template', 'is_visible', 'is_home', 'title'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title'];

    protected static $rules = [];

    protected $errors;

    public $text = '';

    /**
     * Available templates. Should match files in layouts folder.
     *
     * @var array
     */
    public static $templates = ['client_noslider', 'client_wslider'];

    /**
     * The attribute that defines maximum pages depth.
     * Set NULL for unlimited.
     */
    const MAX_LEVEL = 2;

    /**
     * Adds observer inheritance
     */
    public static function boot()
    {
        parent::boot();

        static::created(function(Page $entity) {
            $entity->alterSiblingsPosition('increment');
        });

        static::updating(function(Page $entity) {
            if ($entity->isDirty('parent_id') or $entity->isDirty('position')) {
                $entity->alterSiblingsPosition('decrement', true);
                $entity->alterSiblingsPosition('increment');
            }
        });
        static::saving(function($entity) {
            if (!$entity->slug or $entity->isDirty('slug')) {
                $entity->sluggify(true);
            }
            return $entity->validate();
        });

        static::saved(function(Page $entity) {
            if ($entity->is_home) {
                Page::where('id', '!=', $entity->id)->update(['is_home' => 0]);
                $entity->findAncestors()->update(['is_visible' => true]);
            } else {
                $homePage = Page::whereIsHome(1)->first();
                if ($homePage)
                    $homePage->findAncestors()->update(['is_visible' => true]);
                else
                    $entity->update(['is_home' => true]);
            }
        });

        static::deleted(function(Page $entity) {
            $entity->alterSiblingsPosition('decrement');
        });
    }

    public function validate()
    {
        $validation = Validator::make($this->getAttributes(), static::$rules);

        if ($validation->fails()) {
            $this->errors = $validation->messages();
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function alterSiblingsPosition($method, $useOriginal = false, $condition = '>=') {
        $parentId = $useOriginal ? $this->original['parent_id'] : $this->parent_id;
        $position = $useOriginal ? $this->original['position'] : $this->position;

        $query = $parentId ?
            Page::whereParentId($parentId) :
            Page::whereNull('parent_id');
        $query->whereMenuId($this->menu_id);
        $query->where('position', $condition, $position)->where('id', '!=', $this->id);
        $result = $query->get();
        foreach($result as $row)
            $row->$method('position');
    }

    public function getSubEntitiesAttribute()
    {
        return self::with('translations')->where('parent_id', $this->id)->orderBy('position')->get();
    }

    public static function getSubPagesList()
    {
        $list = [];
        $pages = Page::with('translations')->orderBy('position')->get();
        foreach ($pages as $page) {
            $parentId = (int) $page->parent_id;
            if (!isset($list[$parentId]))
                $list[$parentId] = [];
            $list[$parentId][] = $page->title;
        }
        return $list;
    }

    public static function getPossibleContentTypes($withLabels = false)
    {
        $table = with(new static)->getTable();
        $type = DB::select(DB::raw("SHOW COLUMNS FROM " .$table . " WHERE Field = 'content_type'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }
        if ($withLabels) {
            $labeledEnum = [];
            foreach ($enum as $value) {
                $labeledEnum[$value] = Lang::get('fields.page.content_types.' . $value);
            }
            unset($enum);
            return $labeledEnum;
        }
        return $enum;
    }

    public static function getPossibleShowTitles($withLabels = false)
    {
        $table = with(new static)->getTable();
        $type = DB::select(DB::raw("SHOW COLUMNS FROM " .$table . " WHERE Field = 'show_title'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }
        if ($withLabels) {
            $labeledEnum = [];
            foreach ($enum as $value) {
                $labeledEnum[$value] = Lang::get('fields.page.show_titles.' . $value);
            }
            unset($enum);
            return $labeledEnum;
        }
        return $enum;
    }

    public static function getPossibleTemplates($withLabels = true)
    {
        if (!$withLabels)
            return self::$templates;

        $list = [];
        foreach (self::$templates as $template) {
            $list[$template] = Lang::get('fields.templates.' . $template);
        }
        return $list;
    }

    public static function withComponent($component)
    {
        $material = MaterialTranslation::join('materials', 'material_id', '=', 'materials.id')
            ->whereIsVisible(true)
            ->whereLocale(App::getLocale())
            ->where('text', 'like', "%[component id='$component']%")
            ->first(['material_id AS id']);

        if (!$material)
            return false;

        return self::whereIsVisible(true)->whereContentType('material')->whereContent($material->id)->first();
    }

    public function setParentIdAttribute($value)
    {
        if ($value == 0)
            $value = null;
        $this->attributes['parent_id'] = $value;
    }

    public function setPositionAttribute($value)
    {
        $maxPosition = $this->parent_id ?
            Page::whereParentId($this->parent_id)->count() :
            Page::whereNull('parent_id')->count();
        if (!$this->id or $this->parent_id != $this->getOriginal('parent_id'))
            $maxPosition++;

        if ($value > $maxPosition)
            $value = $maxPosition;

        if ($value < 1)
            $value = 1;

        $this->attributes['position'] = $value;
    }

    public function setIsHomeAttribute($value)
    {
        if ($value)
            $this->attributes['is_visible'] = true;
        $this->attributes['is_home'] = $value;
    }

    public function setIsVisibleAttribute($value)
    {
        if (isset($this->attributes['is_home']) and $this->attributes['is_home'])
            $this->attributes['is_visible'] = true;
        else
            $this->attributes['is_visible'] = $value;
    }

    public static function getPossibleParentIds($options = [], $tree = null, &$list = [])
    {
        if ($tree === null) {
            $excluded = [];
            if (isset($options['excluded'])) {
                $excluded = $options['excluded'];
                if (!is_array($excluded))
                    $excluded = [$excluded];
            }
            $tree = self::getTreeStructure(['menuId' => $options['menuId'], 'withHidden' => true, 'excluded' => $excluded, 'maxLevel' => self::MAX_LEVEL]);
        }

        foreach($tree as $node) {
            $offset = '';
            for($i = 0; $i < $node['level']; $i++)
                $offset .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $list[] = ['id' => $node['id'], 'title' => $offset . ((isset($node['title']) and $node['title']) ? $node['title'] : $node['slug'])];
            self::getPossibleParentIds($options, $node['children'], $list);
        }
        return $list;
    }

    public static function getTreeStructure($options = [])
    {
        $nodeList = [];
        $tree = [];
        $excluded = [];
        $maxLevel = null;

        if (isset($options['excluded']))
            $excluded = is_array($options['excluded']) ? $options['excluded'] : [$options['excluded']];
        if (isset($options['maxLevel']))
            $maxLevel = (int) $options['maxLevel'];

        if (isset($options['menuSlug'])) {
            $query = Page::join('pages_translations', 'pages.id', '=', 'pages_translations.page_id')
                ->select('pages.id', 'title', 'parent_id', 'path', 'level', 'pages.slug', 'content_type', 'content')
                ->whereLocale(App::getLocale())
                ->join('menus', 'pages.menu_id', '=', 'menus.id')
                ->where('menus.slug', '=', $options['menuSlug'])
                ->orderByRaw('parent_id IS NULL DESC, parent_id ASC, position ASC');
        } elseif (isset($options['menuId'])) {
            $query = Page::join('pages_translations', 'pages.id', '=', 'pages_translations.page_id')
                ->select('pages.id', 'title', 'parent_id', 'path', 'level', 'pages.slug', 'content_type', 'content')
                ->whereLocale(App::getLocale())
                ->whereMenuId($options['menuId'])
                ->orderByRaw('parent_id IS NULL DESC, parent_id ASC, position ASC');
        } else {
            throw new MissingMandatoryParametersException('Page::getTreeStructure requires a valid menuId or menuSlug parameter');
        }

        if (!isset($options['withHidden']) or $options['withHidden'] !== true)
            $query->where('is_visible', true);

        $pages = $query->get();

        foreach($pages as $row) {
            $nodeList[$row->id] = array_merge($row->toArray(), ['children' => []]);
        }
        foreach ($nodeList as $nodeId => &$node) {
            $parents = explode('/', $node['path']);
            if (($maxLevel !== null and $node['level'] >= $maxLevel) or in_array($nodeId, $excluded) or array_intersect($parents, $excluded))
                continue;
            if (!$node['parent_id'] || !array_key_exists($node['parent_id'], $nodeList))
                $tree[] = &$node;
            else
                $nodeList[$node['parent_id']]['children'][] = &$node;
        }
        unset($node);
        unset($nodeList);

        return $tree;
    }

    public function menu()
    {
        return $this->belongsTo('\Structure\Menu');
    }

    public static function search($str, $itemsOnPage = 0)
    {
        $mIds = [];
        $mTranslations = MaterialTranslation::select('material_id')
            ->whereLocale(App::getLocale())
            ->where(function($query) use ($str) {
                $query->where('title', 'LIKE', "%$str%")->orWhere('text', 'LIKE', "%$str%");
            })->get();
        foreach($mTranslations as $mTranslation) {
            $mIds[] = $mTranslation->material_id;
        }

        $materials = [];
        if ($mIds) {
            $sql = Material::whereType(Material::TYPE_PAGE)
                ->whereIsVisible(true)
                ->whereIn('id', $mIds);
            $mResult = $sql->get();
            foreach($mResult as $mRow) {
                $materials[$mRow->id] = $mRow->text;
            }
            unset($mRow, $mResult);
        }

        $ids = [];
        $translations = PageTranslation::select('page_id')
            ->whereLocale(App::getLocale())
            ->where('title', 'LIKE', "%$str%")
            ->get();
        foreach($translations as $translation) {
            $ids[] = $translation->page_id;
        }

        if (!$ids and !$materials)
            return false;

        $sql = self::whereIsVisible(true)
                ->where(function($query) use ($ids, $materials) {
                    if ($ids) {
                        $query->whereIn('id', $ids);
                    }
                    if ($materials) {
                        $query->orWhere(function ($query) use ($materials) {
                            $query->whereContentType(self::CONTENT_TYPE_MATERIAL)
                                ->whereIn('content', array_keys($materials));
                        });
                    }
                });

        $pages = $itemsOnPage ? $sql->paginate((int) $itemsOnPage) : $sql->get();
        foreach ($pages as $page) {
            if ($page->content_type == Page::CONTENT_TYPE_MATERIAL and isset($materials[$page->content]))
                $page->text = mb_substr(preg_replace('/\[\w+ id=\'\w+\'\]/', '', strip_tags($materials[$page->content])), 0, 250, 'UTF-8') . '&hellip;';
        }
        return $pages;
    }
}