<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subtasks`.
 */
class m210615_221522_create_subtasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subtasks', [
            'id' => $this->bigPrimaryKey(),
            'taskId' => $this->bigInteger()->notNull(),
            'description' => $this->text()->notNull(),
            'estimatedTime' => $this->bigInteger()->null(),
            'completed' => $this->boolean()->notNull()->defaultValue(false),
            'createdAt' => $this->timestamp()->notNull(),
            'updatedAt' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_subtasks__taskId',
            'subtasks', 'taskId',
            'tasks', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('subtasks');
    }
}
