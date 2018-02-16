<?php

namespace bulldozer\menu\common\ar;

use bulldozer\db\ActiveRecord;

/**
 * Class Menu
 * @package common\models
 *
 * @property integer $id
 * @property string $name
 * @property integer $levels
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%menu}}';
    }
}