<?php

use bulldozer\menu\backend\widgets\SaveButtonsWidget;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \bulldozer\menu\backend\forms\MenuLinkForm $model
 * @var bool $isNew
 */

?>
<?php $form = ActiveForm::begin(); ?>

<?php if ($model->hasErrors()): ?>
    <div class="alert alert-danger">
        <?= $form->errorSummary($model) ?>
    </div>
<?php endif ?>

<?= $form->field($model, 'active')->checkbox() ?>

<?= $form->field($model, 'sort')->textInput(['type' => 'integer']) ?>

<?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

<?= SaveButtonsWidget::widget(['isNew' => $isNew]) ?>

<?php ActiveForm::end(); ?>