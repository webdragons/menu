<?php

namespace bulldozer\menu\backend\forms;

use bulldozer\base\Form;
use Yii;

/**
 * Class MenuForm
 * @package bulldozer\menu\backend\forms
 */
class MenuForm extends Form
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $levels;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string'],

            ['levels', 'required'],
            ['levels', 'integer', 'min' => 1, 'max' => 2],
        ];
    }

    /**
     * @return array
     */
    public function getSavedAttributes(): array
    {
        return [
            'name',
            'levels',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('menu', 'Name'),
            'levels' => Yii::t('menu', 'Levels'),
        ];
    }
}