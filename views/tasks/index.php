<?php

/* @var $this yii\web\View */

use app\models\Task;
use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'Tasks';

?>
<div class="site-index">
  <h1>
      <?= $this->title ?>
      <?= Html::a('Create task', '/tasks/create', ['class' => 'btn btn-success pull-right']) ?>
  </h1>
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'label' => '#',
                ],
                [
                    'attribute' => 'author',
                    'value' => function ($task) {
                        return $task->author->username;
                    },
                    'filter' => $users,
                ],
                [
                    'attribute' => 'executor',
                    'value' => function ($task) {
                        return $task->executor?->username;
                    },
                    'filter' => $users,
                ],
                'title',
                [
                    'attribute' => 'status',
                    'value' => fn($task) => ucwords($task->status, '-'),
                    'label' => 'Status',
                    'filter' => array_map(
                        fn($key) => ucwords(Task::STATUSES[$key], '-'),
                        array_flip(Task::STATUSES)
                    )
                ],
                'estimatedTime',
                [
                    'label' => 'Subtasks',
                    'value' => fn($task) => $task->subtaskSummary
                ],
                [
                    'label' => 'Comments',
                    'value' => fn($task) => count($task->comments)
                ],
                'createdAt',
                'updatedAt',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => [
                        'style' => 'width:7%'
                    ],
                ],
            ],
        ]
    ); ?>

</div>
