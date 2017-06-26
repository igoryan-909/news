<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_image`.
 */
class m170620_121628_create_post_image_table extends Migration
{
    const TABLE_NAME = 'post_image';


    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_post_image' => $this->primaryKey(),
            'fk_post' => $this->integer()->comment('Запись'),
            'path' => $this->string(500)->comment('Путь'),
            'thumb_path' => $this->string(500)->comment('Путь миниатюры'),
            'created_at' => $this->integer()->comment('Создан'),
        ]);

        $this->addForeignKey('fk_post_image_post', self::TABLE_NAME, 'fk_post', 'post', 'id_post', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_post_image_post', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
