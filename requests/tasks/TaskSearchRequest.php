<?php

namespace app\requests\tasks;

use yii\base\Model;

class TaskSearchRequest extends Model
{
    public int|string|null $id = null;
    public ?string $title = null;
    public ?string $status = null;
    public int|string|null $author = null;
    public int|string|null $executor = null;

    public function rules(): array
    {
        return [
            [['id', 'status', 'author', 'executor'], 'integer'],
            [['title', 'description'], 'string']
        ];
    }
}