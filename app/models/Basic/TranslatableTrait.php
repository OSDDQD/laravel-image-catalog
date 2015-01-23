<?php

namespace Basic;

use \Dimsav\Translatable\Translatable as DimsavTranslatable;
use Illuminate\Support\MessageBag;

trait TranslatableTrait {

    use DimsavTranslatable {
        DimsavTranslatable::save as translatableSave;
    }

    protected function saveTranslations()
    {
        $saved = true;
        foreach ($this->translations as $translation)
        {
            if ($saved && $this->isTranslationDirty($translation))
            {
                $translation->setAttribute($this->getRelationKey(), $this->getKey());
                $saved = $translation->save();
                if (!$saved) {
                    if (!$this->errors) {
                        $this->errors = new MessageBag();
                    }
                    $this->errors->merge($translation->getErrors());
                }
            }
        }
        return $saved;
    }

    public function save(array $rules = array(), array $customMessages = array(), array $options = array(), Closure $beforeSave = null, Closure $afterSave = null)
    {
        $existsBeforeSave = $this->exists;
        if ($this->translatableSave($options)) {
            return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
        } else {
            if (!$existsBeforeSave)
                $this->delete();
        }
        return false;
    }

}