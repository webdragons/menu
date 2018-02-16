<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \bulldozer\menu\backend\forms\MenuLinkForm $model
 * @var \bulldozer\menu\common\ar\MenuLink $link
 */

$this->title = Yii::t('menu', 'Update link: {name}', ['name' => $link->label]);
$this->params['breadcrumbs'][] = ['label' => $link->label, 'url' => ['view-link', 'id' => $link->id]];
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
                <?= $this->render('_form', [
                    'model' => $model,
                    'isNew' => false,
                ]) ?>
            </div>
        </section>
    </div>
</div>
