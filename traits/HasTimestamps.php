<?php

namespace app\traits;

use InvalidArgumentException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

trait HasTimestamps
{
    public function __construct()
    {
        parent::__construct();

        if (!($this instanceof ActiveRecord)) {
            throw new InvalidArgumentException(
                'Trait HasTimestamps is only applicable to ActiveRecord inheritors');
        }

        /** @var ActiveRecord $this */
        $this->attachBehavior('timestamps', [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'createdAt',
            'updatedAtAttribute' => 'updatedAt',
            'value' => new Expression('now()'),
        ]);
    }
}