<?php

namespace app\traits;

use yii\db\ActiveRecord;

/**
 * в laravel можно по-человечески работать с аттрибутами модели
 * и этот код немного приближает поведении yii к ларке
 */
trait HasNotSoShittyAttributes
{
    public function __set($name, $value)
    {
        /** @var ActiveRecord $this */

        $method = 'set' . ucwords($name, '_') . 'Attribute';

        if ($this->hasAttribute($name) && method_exists($this, $method)) {
            $this->$method($value);
        } else {
            parent::__set($name, $value);
        }
    }

    public function __get($name)
    {
        /** @var ActiveRecord $this */

        $method = 'get' . ucwords($name, '_') . 'Attribute';

        if ($this->hasAttribute($name) && method_exists($this, $method)) {
            return $this->$method();
        }

        return parent::__get($name);
    }


}