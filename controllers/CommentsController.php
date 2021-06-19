<?php

namespace app\controllers;

use app\requests\comments\CreateCommentRequest;
use app\traits\AuthorizedOnly;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CommentsController extends Controller
{
    use AuthorizedOnly;

    public function actionCreate(int $taskId): Response
    {
        $model = new CreateCommentRequest;

        if ($model->load(Yii::$app->request->post()) && $model->save($taskId)) {
            Yii::$app->session->addFlash('success', 'Comment successfully added');
        }

        return $this->redirect(['/tasks/view', 'id' => $taskId]);
    }
}