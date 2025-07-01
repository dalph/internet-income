<?php

declare(strict_types = 1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use common\models\ReferralLinkEnum;

/**
 * Модель реферальных ссылок
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $description
 * @property integer $status
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
            [['status', 'prior'], 'integer'],
            [['is_top'], 'boolean'],
            [['title'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 500],
            [['url'], 'url'],
            ['status', 'default', 'value' => ReferralLinkEnum::STATUS_ACTIVE],
            ['status', 'in', 'range' => [ReferralLinkEnum::STATUS_ACTIVE, ReferralLinkEnum::STATUS_INACTIVE]],
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
        return ReferralLinkEnum::getStatusList();
    }

    /**
     * Получить название статуса
     */
    public function getStatusName()
    {
        $statusList = self::getStatusList();
        return $statusList[$this->status] ?? 'Неизвестно';
    }

    /**
     * Проверить активность ссылки
     */
    public function isActive()
    {
        return $this->status === ReferralLinkEnum::STATUS_ACTIVE;
    }

    /**
     * Проверить является ли ссылка топовой
     */
    public function isTop()
    {
        return $this->is_top === true;
    }
} 