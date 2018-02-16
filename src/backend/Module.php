<?php

namespace bulldozer\menu\backend;

use bulldozer\App;
use bulldozer\base\BackendModule;
use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Class Module
 * @package bulldozer\menu\backend
 */
class Module extends BackendModule
{
    public $defaultRoute = 'menu';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        if (empty(App::$app->i18n->translations['menu'])) {
            App::$app->i18n->translations['menu'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/../messages',
            ];
        }
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function createController($route)
    {
        $validRoutes = ['menu'];
        $isValidRoute = false;

        foreach ($validRoutes as $validRoute) {
            if (strpos($route, $validRoute) === 0) {
                $isValidRoute = true;
                break;
            }
        }

        return (empty($route) or $isValidRoute)
            ? parent::createController($route)
            : parent::createController("{$this->defaultRoute}/{$route}");
    }

    /*
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $action->controller->view->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Site menu'), 'url' => ['/menu']];

        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function getMenuItems(): array
    {
        $moduleId = isset(App::$app->controller->module) ? App::$app->controller->module->id : '';
        $controllerId = isset(App::$app->controller) ? App::$app->controller->id : '';

        return [
            [
                'label' => Yii::t('menu', 'Site menu'),
                'icon' => 'fa fa-bars',
                'url' => ['/menu'],
                'rules' => ['menu_manage'],
                'active' => $moduleId == 'menu',
            ],
        ];
    }
}