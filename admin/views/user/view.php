<?php

use yii\helpers\Html;
use admin\widgets\detailView\DetailView;

$this->setTitle($model->login);

$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'uk-button uk-button-default uk-button-small']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'uk-button uk-button-danger uk-button-small',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
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
                'id',
                'login',
                [
                    'label' => 'Роль',
                    'value' => $model->getRole($model->role),
                ],
            ],
        ])
        ?>
    </div>

    <?= Html::a('<span class="uk-margin-small-right" uk-icon="plus"></span> Комментарий', ['/user/create-interaction?userId=' . $model->id], ['class' => 'uk-button uk-button-default uk-button-small']) ?>

    <div class="uk-grid uk-grid-small uk-child-width-1-6 uk-margin-top">
        <?php foreach ($interactions as $interaction): ?>
            <div>
                <div class="uk-card uk-card-primary uk-card-small uk-card-body uk-border-rounded">
                    <p><?php echo $interaction->comment; ?></p>
                    <p class="uk-text-right">
                        <sub><?php echo Yii::$app->formatter->format($interaction->create_time, 'date'); ?></sub>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
