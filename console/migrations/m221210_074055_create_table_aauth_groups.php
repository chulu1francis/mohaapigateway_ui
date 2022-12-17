<?php

use yii\db\Migration;

class m221210_074055_create_table_aauth_groups extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%aauth_groups}}',
            [
                'id' => $this->bigPrimaryKey(),
                'name' => $this->text()->notNull(),
                'description' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            $tableOptions
        );

        $this->addForeignKey(
            'groups_createdby_fk',
            '{{%aauth_groups}}',
            ['created_by'],
            '{{%aauth_users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
        $this->addForeignKey(
            'groups_updatedby_fk',
            '{{%aauth_groups}}',
            ['updated_by'],
            '{{%aauth_users}}',
            ['id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%aauth_groups}}');
    }
}
