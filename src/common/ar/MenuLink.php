<?php

namespace bulldozer\menu\common\ar;

use bulldozer\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Class Menu
 * @package common\models
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $active
 * @property integer $parent_id
 * @property integer $level
 * @property integer $sort
 * @property string $label
 * @property string $url
 *
 * @property-read Menu $menu
 */
class MenuLink extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%menu_links}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getMenu(): ActiveQuery
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }
}