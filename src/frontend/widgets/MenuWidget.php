<?php

namespace bulldozer\menu\frontend\widgets;

use bulldozer\App;
use bulldozer\menu\frontend\services\DbMenuService;
use bulldozer\menu\frontend\services\MenuServiceInterface;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Class MenuWidget
 * @package bulldozer\menu\frontend\widgets
 */
class MenuWidget extends Widget
{
    /**
     * @var int
     */
    public $menuId;

    /**
     * @var string
     */
    public $serviceClass = DbMenuService::class;

    /**
     * @var string
     */
    public $view_path;

    /**
     * @var MenuServiceInterface
     */
    private $menuService;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $this->menuService = App::createObject([
            'class' => $this->serviceClass,
        ]);

        if (!($this->menuService instanceof MenuServiceInterface)) {
            throw new InvalidConfigException('serviceClass must be implement MenuServiceInterface');
        }
    }

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        return $this->render($this->view_path, [
            'menu' => $this->menuService->getMenuItems($this->menuId),
        ]);
    }
}