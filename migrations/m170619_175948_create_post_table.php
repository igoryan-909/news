<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m170619_175948_create_post_table extends Migration
{
    const TABLE_NAME = 'post';


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_post' => $this->primaryKey()->comment('Записи'),
            'fk_user' => $this->integer()->comment('Пользователь'),
            'preview' => $this->string(500)->comment('Превью'),
            'content' => $this->text()->comment('Содержимое'),
            'created_at' => $this->integer()->comment('Создан'),
            'updated_at' => $this->integer()->comment('Обновлен'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Статус'),
        ]);

        $this->addForeignKey('fk_post_user', self::TABLE_NAME, 'fk_user', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_post_user', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
