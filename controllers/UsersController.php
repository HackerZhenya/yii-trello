<?php

namespace app\controllers;

use app\requests\users\SignInRequest;
use app\requests\users\SignUpRequest;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class UsersController extends Controller
{
    public $defaultAction = 'sign-in';

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['sign-in', 'sign-up', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['sign-in', 'sign-up'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['sign-out'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSignIn(): Response|string
    {
        $model = new SignInRequest;

        if ($model->load(Yii::$app->request->post()) && $model->signIn()) {
            Yii::$app->session->addFlash('info', "Hi, <b>$model->username</b>! Glad to see you again");
            return $this->goHome();
        } else {
            return $this->render('sign-in', compact('model'));
        }
    }

    public function actionSignUp(): Response|string
    {
        $model = new SignUpRequest;

        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
            Yii::$app->session->addFlash('info', "Welcome on board, <b>$model->username</b>!");
            return $this->goHome();
        } else {
            return $this->render('sign-up', compact('model'));
        }
    }

    public function actionSignOut(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}