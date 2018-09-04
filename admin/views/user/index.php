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
                        'label' => 'Создать', 'url' => ['create'], 'linkOptions' => ['class' => 'uk-button uk-button-primary uk-light'],
                    ],
                ]
            ],
            'dataProvider' => $dataProvider,
            'columns' => [
                'login',
                'role',
                ['class' => 'admin\widgets\gridView\ActionColumn'],
            ],
        ]);
        ?>

    </div>
</div>