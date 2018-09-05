<?php

use admin\widgets\gridView\GridView;

$this->setTitle('Уведомления');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notice-index">

    <div class="panel panel-default panel-body">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'type',
                'status',
                'text',
//                'data',
                [
                    'attribute' => 'data',
                    'content' => function($data) {
                        return $data->data;
                    }
                ],
                ['class' => 'admin\widgets\gridView\ActionColumn'],
            ],
        ]);
        ?>

    </div>
</div>