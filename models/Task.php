<?php

namespace app\models;

use app\helpers\EstimatedTimeHelpers;
use app\traits\HasNotSoShittyAttributes;
use app\traits\HasTimestamps;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Task
 * @package app\models
 *
 * @property int $id
 * @property int $authorId
 * @property int|null $executorId
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property-read User $author
 * @property-read User $executor
 * @property-read Subtask[] $subtasks
 * @property-read Comment[] $comments
 * @property-read string $subtaskSummary
 * @property-read string $estimatedTime
 */
class Task extends ActiveRecord
{
    use HasNotSoShittyAttributes, HasTimestamps;

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in-progress';
    public const STATUS_TESTING = 'testing';
    public const STATUS_DONE = 'done';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_IN_PROGRESS,
        self::STATUS_TESTING,
        self::STATUS_DONE,
    ];

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function rules(): array
    {
        return [
            [['title', 'status'], 'required'],
            ['executorId', 'integer'],
            [['title', 'description', 'status'], 'string'],
            ['status', 'in', 'range' => self::STATUSES],
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'authorId']);
    }

    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'executorId']);
    }

    public function getSubtasks(): ActiveQuery
    {
        return $this->hasMany(Subtask::class, ['taskId' => 'id']);
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['taskId' => 'id'])
                    ->orderBy(['createdAt' => SORT_DESC]);
    }

    public function getSubtaskSummary(): string
    {
        if (count($this->subtasks) === 0) {
            return 'None';
        }

        $completed = count(array_filter($this->subtasks, fn($st) => $st->completed));
        $total = count($this->subtasks);

        return "$completed/$total";
    }

    public function getEstimatedTime(): string
    {
        return EstimatedTimeHelpers::toReadableEstimatedTime(
            array_reduce($this->subtasks, fn($acc, $st) => $acc + $st->estimatedTime, 0)
        );
    }
}