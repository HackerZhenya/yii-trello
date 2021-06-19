<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use app\requests\comments\CreateCommentRequest;
use app\requests\tasks\CreateOrUpdateTaskRequest;
use app\requests\tasks\TaskSearchRequest;
use app\traits\AuthorizedOnly;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class TasksController extends Controller
{
    use AuthorizedOnly;

    private function resolveUsers($withEmpty = false): array
    {
        $users = array_map(
            fn($u) => $u->username,
            ArrayHelper::index(User::find()->all(), 'id')
        );

        if ($withEmpty) {
            $users = [null => null] + $users;
        }

        return $users;
    }

    public function actionIndex(): Response|string
    {
        $search = new TaskSearchRequest;
        $search->load(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider(
                [
                    'query' => Task::find()
                                   ->with(['author', 'executor', 'subtasks'])
                                   ->filterWhere(
                                       [
                                           'and',
                                           ['like', 'title', $search->title],
                                           [
                                               'id' => $search->id,
                                               'status' => $search->status,
                                               'authorId' => $search->author,
                                               'executorId' => $search->executor,
                                           ],
                                       ]
                                   ),
                    'sort' => [
                        'defaultOrder' => [
                            'id' => SORT_DESC
                        ],
                        'attributes' => [
                            'id',
                            'createdAt',
                            'updatedAt'
                        ]
                    ],
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]),
            'searchModel' => $search,
            'users' => $this->resolveUsers(),
        ]);
    }

    public function actionView(int $id): Response|string
    {
        return $this->render('view', [
            'task' => Task::findOne($id),
            'comment' => new CreateCommentRequest,
        ]);
    }

    public function actionCreate(): Response|string
    {
        $model = new CreateOrUpdateTaskRequest;
        $users = $this->resolveUsers(true);

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->addFlash('success', "Task #$model->id created");
            return $this->redirect(['/tasks/view', 'id' => $model->id]);
        } else {
            return $this->render('form', compact('model', 'users'));
        }
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function actionUpdate(int $id): Response|string
    {
        $model = new CreateOrUpdateTaskRequest;
        $model->load([$model->formName() => Task::findOne($id)->attributes]);
        $users = $this->resolveUsers(true);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->addFlash('success', 'Task updated');
            return $this->redirect(['/tasks/view', 'id' => $model->id]);
        } else {
            return $this->render('form', compact('model', 'users'));
        }
    }

    /**
     * @throws \yii\db\StaleObjectException|\Throwable
     * @noinspection PhpMultipleClassDeclarationsInspection
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function actionDelete(int $id): Response
    {
        Task::findOne($id)->delete();
        Yii::$app->session->addFlash('success', "Task #$id deleted");
        return $this->goHome();
    }
}