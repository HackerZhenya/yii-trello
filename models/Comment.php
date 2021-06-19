<?php

namespace app\models;

use app\traits\HasNotSoShittyAttributes;
use app\traits\HasTimestamps;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Comment
 * @package app\models
 *
 * @property int $id
 * @property int $taskId
 * @property int $authorId
 * @property string $comment
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property-read User $author
 */
class Comment extends ActiveRecord
{
    use HasNotSoShittyAttributes, HasTimestamps;

    public static function tableName(): string
    {
        return 'comments';
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'authorId']);
    }

    public function getRelativeTime(): string
    {
        return Yii::$app->formatter->format($this->createdAt, 'relativeTime');
    }
}