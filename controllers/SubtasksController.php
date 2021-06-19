<?php

namespace app\controllers;

use app\models\Subtask;
use app\requests\subtasks\CreateOrUpdateSubtaskRequest;
use app\traits\AuthorizedOnly;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SubtasksController extends Controller
{
    use AuthorizedOnly;

    public function actionCreate(int $taskId): Response|string
    {
        $model = new CreateOrUpdateSubtaskRequest;

        if ($model->load(Yii::$app->request->post()) && $model->create($taskId)) {
            Yii::$app->session->addFlash('success', "Subtask #$model->id created");
            return $this->redirect(['/tasks/view', 'id' => $model->taskId]);
        } else {
            return $this->render('form', compact('model'));
        }
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function actionUpdate(int $id): Response|string
    {
        $model = new CreateOrUpdateSubtaskRequest;
        $model->load([$model->formName() => Subtask::findOne($id)->attributes]);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->addFlash('success', 'Subtask updated');
            return $this->redirect(['/tasks/view', 'id' => $model->taskId]);
        } else {
            return $this->render('form', compact('model'));
        }
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function actionDelete(int $id): Response
    {
        $subtask = Subtask::findOne($id);
        $subtask->delete();

        Yii::$app->session->addFlash('success', 'Subtask deleted');
        return $this->redirect(['/tasks/view', 'id' => $subtask->taskId]);
    }
}