<?php

/* @var $this yii\web\View */

/* @var $model CreateOrUpdateTaskRequest */

/* @var $users User[] */

use app\models\Task;
use app\models\User;
use app\requests\tasks\CreateOrUpdateTaskRequest;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = $model->id
    ? "Task #${model['id']}"
    : "Create new task";

?>
<div class="site-index">
  <h1><?= $this->title ?></h1>
  <br>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]
    ); ?>

    <?= $form->field($model, 'executorId')
             ->dropDownList($users) ?>

    <?= $form->field($model, 'title')
             ->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'description')
             ->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'status')
             ->dropDownList(
                 array_map(
                     fn($key) => ucwords(Task::STATUSES[$key], '-'),
                     array_flip(Task::STATUSES)
                 )
             ) ?>

  <div class="form-group">
	<div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
	</div>
  </div>

    <?php ActiveForm::end(); ?>
</div>
