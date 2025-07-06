<?php

use yii\db\Migration;

/**
 * Handles adding category_id column to table `{{%referral_links}}`.
 */
class m250701_080100_add_category_id_to_referral_links_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%referral_links}}', 'category_id', $this->integer()->null()->comment('ID категории'));
        
        $this->createIndex('idx_referral_links_category_id', '{{%referral_links}}', 'category_id');
        
        $this->addForeignKey(
            'fk_referral_links_category_id',
            '{{%referral_links}}',
            'category_id',
            '{{%referral_link_categories}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_referral_links_category_id', '{{%referral_links}}');
        $this->dropIndex('idx_referral_links_category_id', '{{%referral_links}}');
        $this->dropColumn('{{%referral_links}}', 'category_id');
    }
} 