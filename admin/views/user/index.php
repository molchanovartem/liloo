<?php

use admin\widgets\gridView\GridView;

$this->setTitle('Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <div class="panel panel-default panel-body">

        <?=
        GridView::widget([
            'toolbar' => [
                'items' => [
                    [
                        'label' => 'Создать', 'url' => ['create'], 'linkOptions' => ['class' => 'uk-button uk-button-primary'],
                    ],
                ]
            ],
            'dataProvider' => $dataProvider,
            'columns' => [
                'login',
                [
                    'attribute' => 'role',
                    'content' => function($data) {
                        return $data->getRole($data->role);
                    }
                ],
                ['class' => 'admin\widgets\gridView\ActionColumn'],
            ],
        ]);
        ?>

    </div>
</div>