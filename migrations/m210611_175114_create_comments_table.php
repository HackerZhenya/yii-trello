<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m210611_175114_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->bigPrimaryKey(),
            'taskId' => $this->bigInteger()->notNull(),
            'authorId' => $this->bigInteger()->notNull(),
            'comment' => $this->text()->notNull(),
            'createdAt' => $this->timestamp()->notNull(),
            'updatedAt' => $this->timestamp()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_comments_taskId',
            'comments', 'taskId',
            'tasks', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'fk_comments_authorId',
            'comments', 'authorId',
            'users', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comments');
    }
}
