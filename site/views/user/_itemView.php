<?php use yii\helpers\Html; ?>
<li>
    <?php
    echo $appointment->salon_id ?
        Html::a($appointment->salon->name , '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
        Html::a($appointment->user->profile->name . ' ' . $appointment->user->profile->surname, '/site/web/index.php/executor-map/user-view?id=' . $appointment->user_id); ?>

    <a class="uk-accordion-title" href="#">
        <?php echo $appointment->start_date; ?>
    </a>
    <div class="uk-accordion-content">
        <table class="uk-table uk-table-hover uk-table-divider">
            <thead>
            <tr>
                <th>Процедура</th>
                <th>Длительность</th>
                <th>Стоимость</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointment->appointmentItems as $appointmentItem): ?>
                <tr>
                    <td><?php echo $appointmentItem->service_name; ?></td>
                    <td><?php echo $appointmentItem->service_duration; ?></td>
                    <td><?php echo $appointmentItem->service_price; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</li>