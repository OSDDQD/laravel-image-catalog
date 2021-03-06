<?php

namespace Catalog;

use \Basic\PositionedTrait;
use \Basic\TranslatableTrait;
use \Basic\UploadableInterface;
use \Basic\UploadableTrait;

class Category extends \BaseModel implements UploadableInterface
{
	use TranslatableTrait,
		UploadableTrait,
		PositionedTrait;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'catalog_categories';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['position', 'title', 'description', 'is_visible', 'image', 'image_desc', 'is_intro'];

	/**
	 * The attributes that are translatable.
	 *
	 * @var array
	 */
	public $translatedAttributes = ['title', 'description'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	protected static $rules = [];

	/**
	 * Adds observer inheritance
	 */
	public static function boot()
	{
		parent::boot();

		static::created(function(Category $entity) {
			$entity->alterSiblingsPosition('increment');
		});
		static::updating(function(Category $entity) {
			if ($entity->isDirty('position')) {
				$entity->alterSiblingsPosition('decrement', true);
				$entity->alterSiblingsPosition('increment');
			}
		});
		static::deleted(function(Category $entity) {
			$entity->alterSiblingsPosition('decrement');
            $entity->removeImage('image');
			$entity->removeImage('image_desc');
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
		return '/catalog/category';
	}

	/**
	 * Returns path to directory where uploaded files are stored.
	 * Usually it returns Config::get('app.uploads_root').self::getUploadDir()
	 *
	 * @return string
	 */
	public static function getUploadPath()
	{
		return \Config::get('app.uploads_root').self::getUploadDir();
	}

	/**
	 * Returns slug used to name uploaded files like 'slug-id.ext'
	 *
	 * @return string
	 */
	public static function getUploadSlug()
	{
		return 'category';
	}

	public function album()
	{
		return $this->hasMany('\Catalog\Album', 'category_id');
	}

	public function setPositionAttribute($value)
	{
		$maxPosition = Category::count();

		if (!$this->id)
			$maxPosition++;

		if ($value > $maxPosition)
			$value = $maxPosition;

		if ($value < 1)
			$value = 1;

		$this->attributes['position'] = $value;
	}

	private function alterSiblingsPosition($method, $useOriginal = false, $condition = '>=') {
		$position = $useOriginal ? $this->original['position'] : $this->position;

		$query = Category::where('position', $condition, $position)->where('id', '!=', $this->id);
		$result = $query->get();
		foreach($result as $row)
			$row->$method('position');
	}

}