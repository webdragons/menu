<?php

namespace bulldozer\menu\frontend\services;

/**
 * Interface MenuServiceInterface
 * @package bulldozer\menu\frontend\services
 */
interface MenuServiceInterface
{
    /**
     * @param int|null $id
     * @return array
     */
    public function getMenuItems(?int $id = null): array;
}