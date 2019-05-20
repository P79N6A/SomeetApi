<?php

use yii\db\Migration;

/**
 * Class m190514_091848_authItemData
 */
class m190514_091848_authItemData extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $items = [
            '/backend/activity/add' => ['admin'],
            '/backend/activity/msg' => ['user','admin','founder'],
            '/backend/activity/check' => ['admin'],
            '/backend/activity/get-tag' => ['admin'],
            '/backend/activity/create-act' => ['admin'],
            '/backend/activity/answer' => ['admin'],
            '/backend/classify/index' => ['admin'],
            '/backend/classify/sub-index'=>['admin'],
            '/backend/activity/edit' => ['admin'],
            '/backend/activity/sub' => ['admin'],
            '/backend/activity/sub-index' => ['admin'],
            '/backend/founder/index' => ['admin','founder'],
            '/backend/founder/add' => ['admin','founder'],
            '/backend/founder/space' => ['admin','founder'],
            '/backend/founder/member' => ['admin','founder'],
            '/backend/member/index' => ['admin'],
            '/backend/member/view' => ['admin','founder'],
            '/backend/space/index' => ['admin'],
            '/backend/space/edit' => ['admin'],
            '/backend/space/add' => ['admin'],
            '/backend/upload/upload-image' => ['admin']

        ];

        $authItemTemplate = <<<SQL
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES ('%s', '2', '', null, null, null, null);
SQL;
        $itemChildTemplate = <<<SQL
        INSERT INTO `auth_item_child` (`parent`, `child`) VALUES ('%s', '%s');
SQL;
        $sql = '';
        foreach ($items as $item => $roles) {
            $sql .= sprintf($authItemTemplate, $item);
            foreach ($roles as $role) {
                $sql .= sprintf($itemChildTemplate, $role, $item);
            }
        }
        $this->execute($sql);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190514_091848_authItemData cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190514_091848_authItemData cannot be reverted.\n";

        return false;
    }
    */
}
