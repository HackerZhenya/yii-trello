<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\requests\users\SignUpRequest */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>Please fill out the following fields to register new account:</p>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]
    ); ?>

    <?= $form->field($model, 'username')
             ->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')
             ->passwordInput() ?>

    <?= $form->field($model, 'confirmPassword')
             ->passwordInput() ?>

  <div class="form-group">
	<div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Sign up', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
	  <span style="margin-left: 8px; margin-right: 8px;">or</span>
        <?= Html::a('Sign in', Url::toRoute('users/sign-in'), ['class' => 'btn btn-default']) ?>
	</div>
  </div>

    <?php ActiveForm::end(); ?>
</div>
