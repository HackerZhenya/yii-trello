<?php

namespace app\requests\comments;

use app\models\Comment;
use Yii;
use yii\base\Model;

class CreateCommentRequest extends Model
{
    public string $comment = '';

    public function rules()
    {
        return [
            ['comment', 'required']
        ];
    }

    public function save(int $taskId, ?int $authorId = null): bool
    {
        if (is_null($authorId)) {
            $authorId = Yii::$app->user->id;
        }

        $comment = new Comment;

        $comment->taskId = $taskId;
        $comment->authorId = $authorId;
        $comment->comment = $this->comment;

        return $comment->save();
    }
}