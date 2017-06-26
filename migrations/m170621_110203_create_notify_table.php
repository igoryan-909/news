<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notify`.
 */
class m170621_110203_create_notify_table extends Migration
{
    const TABLE_NAME = 'notify';

    const CLIENT_EMAIL = 1;

    const CLIENT_BROWSER = 2;


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id_notify' => $this->primaryKey()->comment('Идентификатор'),
            'fk_user' => $this->integer()->notNull()->comment('Пользователь'),
            'client' => $this->smallInteger()->comment('Тип уведомления'),
            'client_data' => $this->binary()->comment('Данные клиента'),
            'created_at' => $this->integer()->comment('Создано'),
            'updated_at' => $this->integer()->comment('Обновлено'),
            'status' => $this->smallInteger()->comment('Статус'),
        ]);

        $this->addForeignKey('fk_notify_user', self::TABLE_NAME, 'fk_user', 'user', 'id', 'CASCADE');
        $this->createIndex('ix_notify_fk_user', self::TABLE_NAME, 'fk_user');

        $users = (new \yii\db\Query())->select('*')->from('user')->all($this->getDb());
        $notifyColumns = ['fk_user', 'client', 'client_data', 'created_at', 'updated_at', 'status'];
        $notifyData = [];
        foreach ($users as $user) {
            $notifyData[] = [
                $user['id'],
                self::CLIENT_EMAIL,
                \yii\helpers\Json::encode(['email' => $user['email']]),
                time(),
                time(),
                0,
            ];
            $notifyData[] = [
                $user['id'],
                self::CLIENT_BROWSER,
                null,
                time(),
                time(),
                1,
            ];
        }
        $this->getDb()->createCommand()->batchInsert(self::TABLE_NAME, $notifyColumns, $notifyData)->execute();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_notify_user', self::TABLE_NAME);
        $this->dropIndex('ix_notify_fk_user', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
