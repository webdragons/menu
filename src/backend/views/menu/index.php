<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('menu', 'Site menu');

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
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'label' => Yii::t('menu', 'ID'),
                            'attribute' => 'id',
                        ],
                        [
                            'label' => Yii::t('menu', 'Name'),
                            'content' => function($model) {
                                return Html::a($model->name, ['view', 'id' => $model->id]);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>
            </div>
        </section>
    </div>
</div>
