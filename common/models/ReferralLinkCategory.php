<?php

declare(strict_types = 1);

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\enum\ReferralLinkCategoryStatusEnum;

/**
 * Модель категорий реферальных ссылок
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $prior
 * @property integer $created_at
 * @property integer $updated_at
 */
class ReferralLinkCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%referral_link_categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        return new ReferralLinkCategoryQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['status', 'prior'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [
                'status', 'default', 'value' => ReferralLinkCategoryStatusEnum::STATUS_ACTIVE
            ],
            [
                'status', 'in', 'range' => ReferralLinkCategoryStatusEnum::getValues()
            ],
            ['prior', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'status' => 'Статус',
            'prior' => 'Приоритет',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Получить список статусов
     */
    public static function getStatusList()
    {
        return ReferralLinkCategoryStatusEnum::getTitles();
    }

    /**
     * Получить название статуса
     */
    public function getStatusName()
    {
        return ReferralLinkCategoryStatusEnum::getTitle($this->status);
    }

    /**
     * Проверить активность категории
     */
    public function isActive()
    {
        return $this->status === ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
    }

    /**
     * Получить реферальные ссылки категории
     */
    public function getReferralLinks()
    {
        return $this->hasMany(ReferralLink::class, ['category_id' => 'id']);
    }

    /**
     * Получить активные реферальные ссылки категории
     */
    public function getActiveReferralLinks()
    {
        return $this->hasMany(ReferralLink::class, ['category_id' => 'id'])
            ->active();
    }
} 