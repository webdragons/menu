<?php

namespace bulldozer\menu\backend\widgets;

use yii\base\Widget;

/**
 * Class SaveButtonsWidget
 * @package bulldozer\menu\backend\widgets
 */
class SaveButtonsWidget extends Widget
{
    /**
     * @var bool
     */
    public $isNew;

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        return $this->render('save-buttons', [
            'isNew' => $this->isNew,
        ]);
    }
}