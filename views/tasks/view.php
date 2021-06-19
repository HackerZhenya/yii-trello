<?php

/* @var $this yii\web\View */

use app\models\Subtask;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = "Task #${task['id']}";

?>
<div class="site-index">
  <h1>
      <?= $this->title ?>
	<span class="pull-right">
		<?= Html::a('Edit', Url::to(['/tasks/update', 'id' => $task->id]), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', Url::to(['/tasks/delete', 'id' => $task->id]), ['class' => 'btn btn-danger']) ?>
	  </span>
  </h1>
    <?= DetailView::widget(
        [
            'model' => $task,
            'attributes' => [
                [
                    'label' => 'Author',
                    'value' => $task->author->username,
                ],
                [
                    'label' => 'Executor',
                    'value' => $task->executor?->username,
                ],
                'title',
                'description:ntext',
                [
                    'label' => 'Status',
                    'value' => ucwords($task->status, '-'),
                ],
                'createdAt',
                'updatedAt',
            ],
        ]
    ); ?>

  <br>
  <h3>
	Subtasks
      <?= Html::a('Create subtask', ['/subtasks/create', 'taskId' => $task->id],
                  ['class' => 'btn btn-success pull-right']) ?>
  </h3>

    <?= GridView::widget(
        [
            'dataProvider' => new ArrayDataProvider(['allModels' => $task->subtasks]),
            'columns' => [
                [
                    'class' => CheckboxColumn::class,
                    'multiple' => false,
                    'checkboxOptions' => fn($st) => [
                        'checked' => $st->completed,
                        'onclick' => 'return false;'
                    ],
                ],
                [
                    'attribute' => 'id',
                    'label' => '#',
                ],
                'description:ntext',
                [
                    'attribute' => 'readableEstimatedTime',
                    'label' => 'Estimated Time'
                ],
                'createdAt',
                'updatedAt',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'urlCreator' => function (string $action, Subtask $model) {
                        return Url::to(["/subtasks/$action", 'id' => $model->id]);
                    },
                    'headerOptions' => [
                        'style' => 'width:5%'
                    ],
                ],
            ],
        ]
    ); ?>

  <br>
  <h3>Comments</h3>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'comment-form',
            'action' => Url::to(['/comments/create', 'taskId' => $task->id]),
            'fieldConfig' => [
                'template' => '<div class=\"\">{input}</div><div class=\"\">{error}</div>',
            ],
        ]
    ); ?>

    <?= $form->field($comment, 'comment')
             ->textarea([
                            'placeholder' => 'Your comment here...',
                            'rows' => 3
                        ]) ?>

    <?= Html::submitButton('Add comment', ['class' => 'btn btn-success pull-right', 'name' => 'add-comment']) ?>

    <?php ActiveForm::end(); ?>

  <br><br><br>

    <?php if (count($task->comments) === 0): ?>

	  <center>
          <?php $t = array_rand(array_flip(HOLDER_THEMES)); ?>

          <?php foreach (str_split('NO COMMENTS YET ') as $c): ?>
              <?php if ($c === ' '): ?>
			  <img src="holder.js/32x32?bg=ffffff&text=%20" alt=" ">
              <?php else: ?>
			  <img src="holder.js/32x32?theme=<?= $t ?>&text=<?= $c ?>" alt="<?= $c ?>">
              <?php endif; ?>
          <?php endforeach; ?>
		<img src="holder.js/32x32?theme=<?= $t ?>&text=:(">
	  </center>

    <?php else: ?>

	  <ul class="media-list">
          <?php foreach ($task->comments as $c): ?>
			<li class="media">
			  <div class="media-left">
				<a href="#">
				  <img class="media-object"
					   src="holder.js/64x64?theme=<?= $c->author->holderTheme ?>&size=20&text=<?= strtoupper($c->author->username[0]) ?>"
					   alt="<?= strtoupper($c->author->username[0]) ?>">
				</a>
			  </div>
			  <div class="media-body">
				<h4 class="media-heading"><?= htmlspecialchars($c->author->username) ?> · <?= $c->relativeTime ?></h4>
                  <?= nl2br(htmlspecialchars($c->comment)) ?>
			  </div>
			</li>
          <?php endforeach; ?>
	  </ul>

    <?php endif; ?>

  <br><br><br>
</div>
