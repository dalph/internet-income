<?php

declare(strict_types = 1);

namespace backend\controllers;

use common\models\ReferralLink;
use common\enum\ReferralLinkStatusEnum;
use common\services\ReferralLinkService;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контроллер для управления реферальными ссылками
 */
class ReferralLinkController extends Controller
{
    /**
     * Сервис для работы с реферальными ссылками
     *
     * @var ReferralLinkService
     */
    private ReferralLinkService $referralLinkService;

    public function __construct($id, $module, ReferralLinkService $referralLinkService, $config = [])
    {
        $this->referralLinkService = $referralLinkService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'change-status' => ['POST'],
                    'change-top-status' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список реферальных ссылок
     */
    public function actionIndex()
    {
        $dataProvider = $this->referralLinkService->getDataProvider(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр реферальной ссылки
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Создание новой реферальной ссылки
     */
    public function actionCreate()
    {
        $model = new ReferralLink();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Реферальная ссылка успешно создана.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Обновление реферальной ссылки
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Реферальная ссылка успешно обновлена.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление реферальной ссылки
     */
    public function actionDelete($id)
    {
        $result = $this->referralLinkService->delete($id);
        
        if ($result) {
            Yii::$app->session->setFlash('success', 'Реферальная ссылка успешно удалена.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении реферальной ссылки.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Изменение статуса реферальной ссылки
     */
    public function actionChangeStatus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $status = (integer) Yii::$app->request->post('status');
        
        $result = $this->referralLinkService->changeStatus($id, $status);
        
        if ($result) {
            return ['success' => true, 'message' => 'Статус успешно изменен.'];
        } else {
            return ['success' => false, 'message' => 'Ошибка при изменении статуса.'];
        }
    }

    /**
     * Изменение топового статуса реферальной ссылки
     */
    public function actionChangeTopStatus($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $isTop = (boolean) Yii::$app->request->post('is_top');
        
        $result = $this->referralLinkService->changeTopStatus($id, $isTop);
        
        if ($result) {
            return ['success' => true, 'message' => 'Топовый статус успешно изменен.'];
        } else {
            return ['success' => false, 'message' => 'Ошибка при изменении топового статуса.'];
        }
    }

    /**
     * Найти модель по ID
     */
    protected function findModel($id)
    {
        $model = ReferralLink::findOne($id);
        
        if (null === $model) {
            throw new NotFoundHttpException('Реферальная ссылка не найдена.');
        }

        return $model;
    }
} 