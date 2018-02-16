<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \bulldozer\menu\common\ar\Menu $menu
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = $menu->name;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="panel-actions">
                </div>

                <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
            </header>

            <div class="panel-body">
                <h2>Ссылки</h2>
                <?= Html::a(Yii::t('menu', 'Create menu link'), ['create-link', 'menu_id' => $menu->id], ['class' => 'btn btn-success']) ?>

                <?= $this->render('_links', ['dataProvider' => $dataProvider]) ?>
            </div>
        </section>
    </div>
</div>
