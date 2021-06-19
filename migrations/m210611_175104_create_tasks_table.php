<?php

use app\models\Task;
use yii\db\Migration;

/**
 * Handles the creation of table `tasks`.
 */
class m210611_175104_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tasks', [
            'id' => $this->bigPrimaryKey(),
            'authorId' => $this->bigInteger()->notNull(),
            'executorId' => $this->bigInteger()->null(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'status' => $this->string()->notNull()->defaultValue(Task::STATUS_PENDING),
            'createdAt' => $this->timestamp()->notNull(),
            'updatedAt' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_tasks__authorId',
            'tasks', 'authorId',
            'users', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'fk_tasks__executorId',
            'tasks', 'executorId',
            'users', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tasks');
    }
}
