<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%referral_links}}`.
 */
class m250701_074635_create_referral_links_table extends Migration
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

        $this->createTable('{{%referral_links}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название ссылки'),
            'url' => $this->string(500)->notNull()->comment('Реферальная ссылка'),
            'description' => $this->text()->comment('Описание ссылки'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус ссылки'),
            'is_top' => $this->boolean()->notNull()->defaultValue(false)->comment('Топовая ссылка'),
            'prior' => $this->integer()->notNull()->defaultValue(0)->comment('Приоритет'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_referral_links_status', '{{%referral_links}}', 'status');
        $this->createIndex('idx_referral_links_is_top', '{{%referral_links}}', 'is_top');
        $this->createIndex('idx_referral_links_prior', '{{%referral_links}}', 'prior');
        $this->createIndex('idx_referral_links_created_at', '{{%referral_links}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%referral_links}}');
    }
} 