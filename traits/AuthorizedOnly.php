<?php

namespace app\traits;

use InvalidArgumentException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

trait AuthorizedOnly
{
    public function __construct($id, $module, $config = [])
    {
        if (!($this instanceof Controller)) {
            throw new InvalidArgumentException(
                'Trait AuthorizedOnly is only applicable to Controller inheritors');
        }

        parent::__construct($id, $module, $config);

        /** @var Controller $this */
        $this->attachBehavior('access', [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'allow' => false,
                    'roles' => ['?'],
                    'denyCallback' => function ($rule, $action) {
                        Yii::$app->response->redirect('/users/sign-in');
                    }
                ],
            ],
        ]);
    }
}