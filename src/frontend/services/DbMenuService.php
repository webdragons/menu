<?php

namespace bulldozer\menu\frontend\services;

use bulldozer\App;
use bulldozer\menu\common\ar\Menu;
use bulldozer\menu\common\ar\MenuLink;
use yii\base\InvalidConfigException;

/**
 * Class DbMenuService
 * @package bulldozer\menu\frontend\services
 */
class DbMenuService implements MenuServiceInterface
{
    /**
     * @param int|null $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getMenuItems(?int $id = null): array
    {
        if ($id === null) {
            throw new InvalidConfigException('You must set id for this menu');
        }

        $menu = $this->getMenu($id);
        $links = $this->getMenuLinks($menu);

        $elements = [];

        foreach ($links as $link) {
            $elements[$link->parent_id][] = $link;
        }

        return $this->buildRecursiveTree($elements, 0);
    }


    /**
     * @param int $id
     * @return Menu
     * @throws \yii\base\InvalidConfigException
     */
    protected function getMenu(int $id): Menu
    {
        $menu = Menu::findOne($id);

        if ($menu === null) {
            /** @var Menu $menu */
            $menu = App::createObject([
                'class' => Menu::class,
                'name' => 'Menu ' . $id,
            ]);
            $menu->save();
        }

        return $menu;
    }

    /**
     * @param Menu $menu
     * @return array
     */
    protected function getMenuLinks(Menu $menu): array
    {
        return MenuLink::find()
            ->andWhere(['active' => 1])
            ->andWhere(['menu_id' => $menu->id])
            ->addOrderBy(['parent_id' => SORT_ASC])
            ->addOrderBy(['sort' => SORT_ASC])
            ->all();
    }

    /**
     * @param array $links
     * @param int $parent_id
     * @return array
     */
    protected function buildRecursiveTree(array $links, int $parent_id): array
    {
        $elements = [];

        if (isset($links[$parent_id])) {
            /** @var MenuLink $link */
            foreach ($links[$parent_id] as $link) {
                $elements[] = [
                    'label' => $link->label,
                    'url' => $link->url,
                    'childs' => $this->buildRecursiveTree($links, $link->id),
                ];
            }
        }

        return $elements;
    }
}