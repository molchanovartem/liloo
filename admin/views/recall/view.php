<?php

use yii\helpers\Html;
use admin\widgets\detailView\DetailView;

$this->setTitle('Отзыв');

$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?= Html::a('<span class="uk-margin-small-right" uk-icon="check"></span> Проверено', ['/recall/check?id=' . $model->id], ['class' => 'uk-button uk-button-default uk-button-small']) ?>

        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'uk-button uk-button-danger uk-button-small',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот отзыв?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <div>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'appointment_id',
                'text',
                'assessment',
                [
                    'label' => 'Статус',
                    'value' => $model->getStatus($model->status),
                ],
            ],
        ])
        ?>
    </div>
</div>
