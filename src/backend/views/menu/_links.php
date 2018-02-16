<?php

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use bulldozer\menu\common\ar\MenuLink;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => Yii::t('menu', 'Name'),
            'content' => function(MenuLink $model) {
                if ($model->menu->levels <= $model->level) {
                    return $model->label;
                } else {
                    return Html::a($model->label, ['view-link', 'id' => $model->id]);
                }
            },
        ],
        [
            'label' => Yii::t('menu', 'Link'),
            'attribute' => 'url',
        ],
        [
            'label' => Yii::t('menu', 'Active'),
            'attribute' => 'active',
            'format' => 'boolean',
        ],
        [
            'label' => Yii::t('menu', 'Display order'),
            'attribute' => 'sort',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'urlCreator' => function($action, $model, $key, $index) {
                if ($action == 'update') {
                    return Url::to(['update-link', 'id' => $model->id]);
                } else if ($action == 'delete') {
                    return Url::to(['delete-link', 'id' => $model->id]);
                }
            },
        ],
    ],
]); ?>
