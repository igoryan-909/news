<?php

use yii\db\Migration;

class m170620_071652_add_title_into_post extends Migration
{
    const TABLE_NAME = 'post';


    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'title', $this->string(255)->comment('Заголовок'));
    }

    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'title');
    }
}
