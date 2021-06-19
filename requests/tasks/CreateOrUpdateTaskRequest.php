<?php

namespace app\requests\tasks;

use app\models\Task;
use Yii;
use yii\base\Model;

class CreateOrUpdateTaskRequest extends Model
{
    public ?int $id = null;
    public int|string|null $executorId = null;
    public string $title = '';
    public ?string $description = null;
    public string $status = Task::STATUS_PENDING;

    public function rules(): array
    {
        return [
            [['executorId', 'description'], 'default', 'value' => null],
            [['title', 'status'], 'required'],
            [['id', 'executorId'], 'integer'],
            [['title', 'description', 'status'], 'string'],
            ['status', 'in', 'range' => Task::STATUSES],
        ];
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    public function attributeLabels(): array
    {
        return [
            'executorId' => 'Executor',
        ];
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function create(): bool
    {
        if ($this->validate()) {
            $task = new Task;
            $task->authorId = Yii::$app->user->id;
            if ($task->load([$task->formName() => $this->attributes]) && $task->save()) {
                $this->id = $task->id;
                return true;
            }
        }

        return false;
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     */
    public function update(): bool
    {
        if ($this->validate()) {
            $task = Task::findOne($this->id);
            return $task->load([$task->formName() => $this->attributes]) && $task->save();
        }

        return false;
    }
}