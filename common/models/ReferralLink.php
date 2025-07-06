<?php

declare(strict_types = 1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use common\enum\ReferralLinkStatusEnum;
use common\models\ReferralLinkCategory;

/**
 * Модель реферальных ссылок
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $description
 * @property integer $status
 * @property integer $category_id
 * @property boolean $is_top
 * @property integer $prior
 * @property integer $created_at
 * @property integer $updated_at
 */
class ReferralLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%referral_links}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        return new ReferralLinkQuery(get_called_class());
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
            [['title', 'url'], 'required'],
            [['description'], 'string'],
            [['status', 'category_id', 'prior'], 'integer'],
            [['is_top'], 'boolean'],
            [['title'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 500],
            [['url'], 'url'],
            ['category_id', 'exist', 'targetClass' => ReferralLinkCategory::class, 'targetAttribute' => 'id'],
            [
                'status', 
                'default', 
                'value' => ReferralLinkStatusEnum::STATUS_ACTIVE,
            ],
            [
                'status', 
                'in', 
                'range' => ReferralLinkStatusEnum::getValues(),
            ],
            ['is_top', 'default', 'value' => false],
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
            'url' => 'Ссылка',
            'description' => 'Описание',
            'status' => 'Статус',
            'category_id' => 'Категория',
            'is_top' => 'Топовая ссылка',
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
        return ReferralLinkStatusEnum::getTitles();
    }

    /**
     * Получить название статуса
     */
    public function getStatusName()
    {
        return ReferralLinkStatusEnum::getTitle($this->status);
    }

    /**
     * Проверить активность ссылки
     */
    public function isActive()
    {
        return $this->status === ReferralLinkStatusEnum::STATUS_ACTIVE;
    }

    /**
     * Проверить является ли ссылка топовой
     */
    public function isTop()
    {
        return $this->is_top === true;
    }

    /**
     * Получить категорию ссылки
     */
    public function getCategory()
    {
        return $this->hasOne(ReferralLinkCategory::class, ['id' => 'category_id']);
    }
} 