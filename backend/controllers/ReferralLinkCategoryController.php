<?php

declare(strict_types = 1);

namespace backend\controllers;

use common\models\ReferralLinkCategory;
use common\models\ReferralLinkCategoryQuery;
use common\services\ReferralLinkCategoryService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контроллер для управления категориями реферальных ссылок
 */
class ReferralLinkCategoryController extends Controller
{
    /**
     * Сервис для работы с категориями
     *
     * @var ReferralLinkCategoryService
     */
    private ReferralLinkCategoryService $service;

    public function __construct($id, $module, ReferralLinkCategoryService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список всех категорий
     */
    public function actionIndex()
    {
        $query = ReferralLinkCategory::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'prior' => SORT_ASC,
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр категории
     */
    public function actionView(?string $id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Создание новой категории
     */
    public function actionCreate()
    {
        $model = new ReferralLinkCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Категория успешно создана.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Редактирование категории
     */
    public function actionUpdate(?string $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Категория успешно обновлена.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление категории
     */
    public function actionDelete(?string $id)
    {
        $model = $this->findModel($id);
        
        if ($this->service->delete($model)) {
            Yii::$app->session->setFlash('success', 'Категория успешно удалена.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось удалить категорию.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Найти модель по ID
     */
    protected function findModel(?string $id): ReferralLinkCategory
    {
        $id = (int) $id;
        
        if (($model = ReferralLinkCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Категория не найдена.');
    }
} 