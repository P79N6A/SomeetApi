<?php

use yii\db\Migration;

/**
 * Class m190311_031600_user
 */
class m190311_031600_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190311_031600_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190311_031600_user cannot be reverted.\n";

        return false;
    }
    */
}
