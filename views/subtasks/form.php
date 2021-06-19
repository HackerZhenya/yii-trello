<?php

/* @var $this yii\web\View */

/* @var $model CreateOrUpdateTaskRequest */

/* @var $users User[] */

use app\models\User;
use app\requests\tasks\CreateOrUpdateTaskRequest;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = $model->id
    ? "Subtask #${model['id']}"
    : "Create new subtask";

?>
<div class="site-index">
  <h1><?= $this->title ?></h1>
  <br>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=col-lg-4>{input}</div>\n<div class=col-lg-6>{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]
    ); ?>

    <?= $form->field($model, 'description')
             ->textarea(['autofocus' => true, 'rows' => 3]) ?>

    <?= $form->field($model, 'completed', ['wrapperOptions' => ['class' => 'col-lg-6 col-lg-offset-2']])
             ->checkbox() ?>

    <?= $form->field($model, 'estimatedTimeDays', [
        'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon">days</div></div>',
    ])
             ->input('number')
             ->label('Estimated Time'); ?>

    <?= $form->field($model, 'estimatedTimeHours', [
        'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon">hours</div></div>',
    ])
             ->input('number')
             ->label(''); ?>

    <?= $form->field($model, 'estimatedTimeMinutes', [
        'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon">minutes</div></div>',
    ])
             ->input('number')
             ->label(''); ?>

  <div class="form-group">
	<div class="col-lg-offset-2 col-lg-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
	</div>
  </div>

    <?php ActiveForm::end(); ?>
</div>
