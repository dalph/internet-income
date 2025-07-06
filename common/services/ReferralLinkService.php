<?php

declare(strict_types = 1);

namespace common\services;

use common\models\ReferralLink;
use common\enum\ReferralLinkStatusEnum;
use yii\data\ActiveDataProvider;

/**
 * Сервис для работы с реферальными ссылками
 */
class ReferralLinkService
{
    /**
     * Создать новую реферальную ссылку
     */
    public function create($data)
    {
        $model = new ReferralLink();
        $model->load($data, '');
        
        if ($model->save()) {
            return $model;
        }
        
        return false;
    }

    /**
     * Обновить реферальную ссылку
     */
    public function update($id, $data)
    {
        $model = ReferralLink::findOne($id);
        
        if (null === $model) {
            return false;
        }
        
        $model->load($data, '');
        
        if ($model->save()) {
            return $model;
        }
        
        return false;
    }

    /**
     * Удалить реферальную ссылку
     */
    public function delete($id)
    {
        $model = ReferralLink::findOne($id);
        
        if (null === $model) {
            return false;
        }
        
        return 1 === $model->delete();
    }

    /**
     * Изменить статус реферальной ссылки
     */
    public function changeStatus($id, $status)
    {
        $model = ReferralLink::findOne($id);
        
        if (null === $model) {
            return false;
        }
        
        if (false === ReferralLinkStatusEnum::hasValue($status)) {
            return false;
        }
        
        $model->status = $status;
        
        return false !== $model->save();
    }

    /**
     * Изменить топовый статус реферальной ссылки
     */
    public function changeTopStatus($id, $isTop)
    {
        $model = ReferralLink::findOne($id);
        
        if (null === $model) {
            return false;
        }
        
        $model->is_top = (boolean) $isTop;
        
        return false !== $model->save();
    }

    /**
     * Получить активные реферальные ссылки
     */
    public function getActiveLinks()
    {
        return ReferralLink::find()
            ->active()
            ->byTopAndPriority()
            ->all();
    }

    /**
     * Получить активные реферальные ссылки без категорий
     */
    public function getActiveLinksWithoutCategory()
    {
        return ReferralLink::find()
            ->active()
            ->andWhere(['category_id' => null])
            ->byTopAndPriority()
            ->all();
    }

    /**
     * Получить топовые активные реферальные ссылки
     */
    public function getTopActiveLinks()
    {
        return ReferralLink::find()
            ->active()
            ->top()
            ->byPriority()
            ->all();
    }

    /**
     * Получить провайдер данных для списка ссылок
     */
    public function getDataProvider($params = [])
    {
        $query = ReferralLink::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'is_top' => SORT_DESC,
                    'prior' => SORT_DESC,
                    'created_at' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        if (false === $this->loadModel($query, $params)) {
            return $dataProvider;
        }
        
        return $dataProvider;
    }

    /**
     * Загрузить параметры поиска в модель
     */
    protected function loadModel($query, $params)
    {
        if (isset($params['title']) && false === empty($params['title'])) {
            $query->byTitle($params['title']);
        }
        
        if (isset($params['status']) && ReferralLinkStatusEnum::hasValue($params['status'])) {
            $query->andWhere(['status' => $params['status']]);
        }
        
        if (isset($params['is_top'])) {
            $isTop = (boolean) $params['is_top'];
            
            if ($isTop) {
                $query->top();
            } else {
                $query->notTop();
            }
        }
        
        if (isset($params['category_id']) && false === empty($params['category_id'])) {
            $query->andWhere(['category_id' => $params['category_id']]);
        }
        
        return true;
    }
} 