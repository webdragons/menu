<?php

namespace bulldozer\menu\backend\controllers;

use bulldozer\App;
use bulldozer\menu\backend\forms\MenuForm;
use bulldozer\menu\backend\forms\MenuLinkForm;
use bulldozer\menu\backend\services\MenuService;
use bulldozer\menu\common\ar\Menu;
use bulldozer\menu\common\ar\MenuLink;
use bulldozer\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class MenuController
 * @package bulldozer\menu\backend\controllers
 */
class MenuController extends Controller
{
    /**
     * @var MenuService
     */
    private $menuService;

    /**
     * MenuController constructor.
     * @param string $id
     * @param $module
     * @param MenuService $menuService
     * @param array $config
     */
    public function __construct(string $id, $module, MenuService $menuService, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->menuService = $menuService;
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'view', 'create-link', 'update-link', 'delete-link', 'view-link'],
                        'allow' => true,
                        'roles' => ['menu_manage'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(): string
    {
        $dataProvider = App::createObject([
            'class' => ActiveDataProvider::class,
            'query' => Menu::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionView(int $id): string
    {
        $menu = Menu::findOne($id);

        if ($menu === null) {
            throw new NotFoundHttpException();
        }

        $dataProvider = App::createObject([
            'class' => ActiveDataProvider::class,
            'query' => MenuLink::find()->andWhere(['menu_id' => $menu->id])
        ]);

        return $this->render('view', [
            'menu' => $menu,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionViewLink(int $id): string
    {
        $link = MenuLink::findOne($id);

        if ($link === null) {
            throw new NotFoundHttpException();
        }

        $dataProvider = App::createObject([
            'class' => ActiveDataProvider::class,
            'query' => MenuLink::find()
                ->andWhere(['menu_id' => $link->menu_id])
                ->andWhere(['parent_id' => $link->id])
        ]);

        return $this->render('view-link', [
            'link' => $link,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(int $id)
    {
        $menu = Menu::findOne($id);

        if ($menu === null) {
            throw new NotFoundHttpException();
        }

        /** @var MenuForm $model */
        $model = App::createObject([
            'class' => MenuForm::class,
        ]);
        $model->setAttributes($menu->getAttributes($model->getSavedAttributes()));

        if ($model->load(App::$app->request->post()) && $model->validate()) {
            if ($this->menuService->saveMenu($model, $menu)) {
                App::$app->getSession()->setFlash('success', Yii::t('menu', 'Menu successful updated'));

                if (!App::$app->request->post('here-btn')) {
                    return $this->redirect(['view', 'id' => $menu->id]);
                } else {
                    return $this->redirect(['update', 'id' => $menu->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'menu' => $menu,
        ]);
    }

    /**
     * @param int $menu_id
     * @param int $parent_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreateLink(int $menu_id, int $parent_id = 0)
    {
        $menu = Menu::findOne($menu_id);

        if ($menu === null) {
            throw new NotFoundHttpException();
        }

        /** @var MenuLinkForm $model */
        $model = App::createObject([
            'class' => MenuLinkForm::class,
            'menu_id' => $menu_id,
            'parent_id' => $parent_id,
        ]);

        if ($model->load(App::$app->request->post()) && $model->validate()) {
            if ($link = $this->menuService->saveLink($model)) {
                App::$app->getSession()->setFlash('success', Yii::t('menu', 'Link successful created'));

                if (!App::$app->request->post('here-btn')) {
                    return $this->redirect(['view', 'id' => $menu->id]);
                } else {
                    return $this->redirect(['update-link', 'id' => $link->id]);
                }
            }
        }

        return $this->render('create-link', [
            'model' => $model,
            'menu' => $menu,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateLink(int $id)
    {
        $link = MenuLink::findOne($id);

        if ($link === null) {
            throw new NotFoundHttpException();
        }

        /** @var MenuLinkForm $model */
        $model = App::createObject([
            'class' => MenuLinkForm::class,
        ]);
        $model->setAttributes($link->getAttributes($model->getSavedAttributes()));

        if ($model->load(App::$app->request->post()) && $model->validate()) {
            if ($this->menuService->saveLink($model, $link)) {
                App::$app->getSession()->setFlash('success', Yii::t('menu', 'Link successful updated'));

                if (!App::$app->request->post('here-btn')) {
                    return $this->redirect(['view', 'id' => $link->menu_id]);
                } else {
                    return $this->redirect(['update-link', 'id' => $link->id]);
                }
            }
        }

        return $this->render('update-link', [
            'model' => $model,
            'link' => $link,
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteLink(int $id)
    {
        $link = MenuLink::findOne($id);

        if ($link === null) {
            throw new NotFoundHttpException();
        }

        $menu_id = $link->menu_id;

        $link->delete();

        App::$app->getSession()->setFlash('success', Yii::t('menu', 'Link successful deleted'));

        return $this->redirect(['view', 'id' => $menu_id]);
    }
}