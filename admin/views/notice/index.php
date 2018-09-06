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
                [
                    'attribute' => 'type',
                    'content' => function ($data) {
                        return $data->getType($data->type);
                    }
                ],
                [
                    'attribute' => 'status',
                    'content' => function ($data) {
                        return $data->getStatus($data->status);
                    }
                ],
                'text',
                [
                    'attribute' => 'data',
                    'content' => function ($data) {
                        return json_encode($data->data);
                    }
                ],
                ['class' => 'admin\widgets\gridView\ActionColumn'],
            ],
        ]);
        ?>

    </div>
</div>