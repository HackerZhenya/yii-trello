<?php

namespace app\models;

use app\helpers\EstimatedTimeHelpers;
use app\traits\HasNotSoShittyAttributes;
use app\traits\HasTimestamps;
use yii\db\ActiveRecord;

/**
 * Class Subtask
 * @package app\models
 *
 * @property int $id
 * @property int $taskId
 * @property string $description
 * @property int|null $estimatedTime
 * @property bool $completed
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property-write array $estimatedTimeParts
 * @property-read string $readableEstimatedTime
 */
class Subtask extends ActiveRecord
{
    use HasNotSoShittyAttributes, HasTimestamps;

    public static function tableName(): string
    {
        return 'subtasks';
    }

    public function setEstimatedTimeParts(array $array): void
    {
        $this->estimatedTime = EstimatedTimeHelpers::estimatedTimeFromParts($array);
    }

    public function getReadableEstimatedTime(): string
    {
        return EstimatedTimeHelpers::toReadableEstimatedTime($this->estimatedTime);
    }
}