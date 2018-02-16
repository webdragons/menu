<?php

namespace bulldozer\menu\backend\services;

use bulldozer\App;
use bulldozer\menu\backend\forms\MenuForm;
use bulldozer\menu\backend\forms\MenuLinkForm;
use bulldozer\menu\common\ar\Menu;
use bulldozer\menu\common\ar\MenuLink;

/**
 * Class MenuService
 * @package backend\modules\settings\services
 */
class MenuService
{
    /**
     * @param MenuForm $menuForm
     * @param Menu $menu
     * @return Menu|null
     */
    public function saveMenu(MenuForm $menuForm, Menu $menu): ?Menu
    {
        $menu->setAttributes($menuForm->getAttributes($menuForm->getSavedAttributes()));

        if ($menu->save()) {
            return $menu;
        }

        return null;
    }

    /**
     * @param MenuLinkForm $menuLinkForm
     * @param MenuLink|null $menuLink
     * @return MenuLink|null
     * @throws \yii\base\InvalidConfigException
     */
    public function saveLink(MenuLinkForm $menuLinkForm, MenuLink $menuLink = null): ?MenuLink
    {
        if ($menuLink === null) {
            $menuLink = App::createObject([
                'class' => MenuLink::class,
            ]);
        }

        $menuLink->setAttributes($menuLinkForm->getAttributes($menuLinkForm->getSavedAttributes()));

        if ($menuLinkForm->parent_id != 0) {
            $parentMenuLink = MenuLink::findOne($menuLinkForm->parent_id);

            if ($parentMenuLink) {
                $menuLink->level = $parentMenuLink->level + 1;
            }
        }

        if ($menuLink->save()) {
            return $menuLink;
        }

        return null;
    }
}