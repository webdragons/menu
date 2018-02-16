<?php

use bulldozer\menu\backend\widgets\SaveButtonsWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \bulldozer\menu\backend\forms\MenuForm $model
 * @var \bulldozer\menu\common\ar\Menu $menu
 */

$this->title = Yii::t('menu', 'Update menu: {name}', ['name' => $menu->name]);
$this->params['breadcrumbs'][] = ['label' => $menu->name, 'url' => ['view-link', 'id' => $menu->id]];
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
                <?php $form = ActiveForm::begin(); ?>

                <?php if ($model->hasErrors()): ?>
                    <div class="alert alert-danger">
                        <?= $form->errorSummary($model) ?>
                    </div>
                <?php endif ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'levels')->textInput() ?>

                <?= SaveButtonsWidget::widget(['isNew' => false]) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
