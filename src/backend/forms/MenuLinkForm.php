<?php

namespace bulldozer\menu\backend\forms;

use bulldozer\base\Form;
use bulldozer\menu\common\ar\MenuLink;
use Yii;

/**
 * Class MenuLinkForm
 * @package bulldozer\menu\backend\forms
 */
class MenuLinkForm extends Form
{
    /**
     * @var int
     */
    public $menu_id;

    /**
     * @var int
     */
    public $parent_id;

    /**
     * @var int
     */
    public $active;

    /**
     * @var int
     */
    public $sort;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $url;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        if ($this->sort === null) {
            $link = MenuLink::find()->orderBy(['sort' => SORT_DESC])->limit(1)->one();

            if ($link) {
                $this->sort = $link->sort + 100;
            } else {
                $this->sort = 100;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['menu_id', 'integer'],

            ['parent_id', 'integer'],

            ['sort', 'required'],
            ['sort', 'integer', 'min' => 0],

            ['active', 'boolean'],

            ['label', 'required'],
            ['label', 'string'],

            ['url', 'required'],
            ['url', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function getSavedAttributes(): array
    {
        return [
            'menu_id',
            'parent_id',
            'active',
            'sort',
            'label',
            'url',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'active' => Yii::t('menu', 'Active'),
            'sort' => Yii::t('menu', 'Display order'),
            'label' => Yii::t('menu', 'Label'),
            'url' => Yii::t('menu', 'Link'),
        ];
    }
}