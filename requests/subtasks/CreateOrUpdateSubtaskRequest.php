<?php

namespace app\requests\subtasks;

use app\helpers\EstimatedTimeHelpers;
use app\models\Subtask;
use yii\base\Model;

/**
 * Class CreateOrUpdateSubtaskRequest
 * @package app\requests\subtasks
 *
 * @property int $estimatedTime
 */
class CreateOrUpdateSubtaskRequest extends Model
{
    public ?int $id = null;
    public ?int $taskId = null;
    public ?string $description = null;
    public int $estimatedTimeDays = 0;
    public int $estimatedTimeHours = 0;
    public int $estimatedTimeMinutes = 0;
    public bool $completed = false;

    public function rules(): array
    {
        return [
            ['description', 'string'],
            ['completed', 'boolean'],
            ['estimatedTime', 'safe'],
            [['id', 'taskId', 'estimatedTimeDays', 'estimatedTimeHours', 'estimatedTimeMinutes'], 'integer'],
            ['description', 'default', 'value' => null],
            [['description', 'estimatedTimeDays', 'estimatedTimeHours', 'estimatedTimeMinutes'], 'required'],
        ];
    }

    public function setEstimatedTime(int $value): void
    {
        [
            $this->estimatedTimeDays,
            $this->estimatedTimeHours,
            $this->estimatedTimeMinutes
        ] = EstimatedTimeHelpers::estimatedTimeToParts($value);
    }

    public function create(int $taskId): bool
    {
        if ($this->validate()) {
            $subtask = new Subtask;

            $subtask->taskId = $taskId;
            $subtask->description = $this->description;
            $subtask->completed = $this->completed;
            $subtask->estimatedTimeParts = [
                $this->estimatedTimeDays,
                $this->estimatedTimeHours,
                $this->estimatedTimeMinutes,
            ];

            if ($subtask->save()) {
                $this->id = $subtask->id;
                $this->taskId = $subtask->taskId;
                return true;
            }
        }

        return false;
    }

    public function update(): bool
    {
        if ($this->validate()) {
            $subtask = Subtask::findOne($this->id);

            $subtask->description = $this->description;
            $subtask->completed = $this->completed;
            $subtask->estimatedTimeParts = [
                $this->estimatedTimeDays,
                $this->estimatedTimeHours,
                $this->estimatedTimeMinutes,
            ];

            return $subtask->save();
        }

        return false;
    }
}