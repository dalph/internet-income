<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%referral_link_categories}}`.
 */
class m250701_080000_create_referral_link_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%referral_link_categories}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название категории'),
            'description' => $this->text()->comment('Описание категории'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус категории'),
            'prior' => $this->integer()->notNull()->defaultValue(0)->comment('Приоритет'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_referral_link_categories_status', '{{%referral_link_categories}}', 'status');
        $this->createIndex('idx_referral_link_categories_prior', '{{%referral_link_categories}}', 'prior');
        $this->createIndex('idx_referral_link_categories_created_at', '{{%referral_link_categories}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%referral_link_categories}}');
    }
} 