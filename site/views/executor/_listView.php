<?php

use yii\widgets\ListView;
?>

<?= ListView::widget([
    'itemView' => '_itemView',
//    'layout' => "{summary}\n{items}\n{pager}",
    'dataProvider' => $provider,
])?>
