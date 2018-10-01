<?php

use admin\widgets\gridView\GridView;

$this->setTitle('Тарифы');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tariff-index">

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
                'name',
                'description',
                [
                    'attribute' => 'type',
                    'content' => function($data) {
                        return $data->getTypeName();
                    }
                ],
                [
                    'attribute' => 'status',
                    'content' => function($data) {
                        return $data->getStatusName();
                    }
                ],
                'quantity',
                ['class' => 'admin\widgets\gridView\ActionColumn'],
            ],
        ]);
        ?>

    </div>
</div>