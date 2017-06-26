<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_track`.
 */
class m170621_162501_create_post_track_table extends Migration
{
    const TABLE_NAME = 'post_track';


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_post_track' => $this->primaryKey()->comment('Идентификатор'),
            'fk_post' => $this->integer() -> comment('Запись'),
            'fk_user' => $this->integer() -> comment('Пользователь'),
            'read_at' => $this->integer()->comment('Прочитано'),
        ]);
        $this->addForeignKey('fk_post_track_post', self::TABLE_NAME, 'fk_post', 'post', 'id_post', 'CASCADE');
        $this->addForeignKey('fk_post_track_user', self::TABLE_NAME, 'fk_user', 'user', 'id', 'CASCADE');
        $this->createIndex('ix_post_track_fk_post', self::TABLE_NAME, 'fk_post');
        $this->createIndex('ix_post_track_fk_user', self::TABLE_NAME, 'fk_user');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_post_track_post', self::TABLE_NAME);
        $this->dropForeignKey('fk_post_track_user', self::TABLE_NAME);
        $this->dropIndex('ix_post_track_fk_post', self::TABLE_NAME);
        $this->dropIndex('ix_post_track_fk_user', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
