<?php

namespace EloquentSluggable;

use \App;
use \Config;
use \Cviebrock\EloquentSluggable\SluggableTrait as CviebrockSluggableTrait;

trait SluggableTrait
{

    use CviebrockSluggableTrait;

    /**
     * ===========================================================
     * Do not forget about handling dirty slug on entity updating!
     * ===========================================================
     */

    /**
     * Sluggable trait configuration.
     *
     * @var array
     */
    public $sluggable = [
        'build_from' => 'slugortitle',
        'save_to' => 'slug',
    ];

    public function getSlugOrTitleAttribute()
    {
        if ($this->slug)
            return $this->slug;
        if (isset($this->translatedAttributes) and in_array('title', $this->translatedAttributes)) {
            if (!$title = $this->translate(App::getLocale())->title) {
                foreach (Config::get('app.locales') as $locale) {
                    if ($title = $this->translate($locale)->title)
                        break;
                }
            }
        } else {
            $title = $this->title;
        }

        return transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $title);
    }

}