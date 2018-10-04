<?php use yii\widgets\ListView; ?>

<?= ListView::widget([
    'itemView' => '_itemView',
    'dataProvider' => $data['dataProvider'],
])?>
