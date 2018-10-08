<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>

<?php foreach ($model as $appointment): ?>
    <li>
        <?php echo $appointment->salon_id ?
            Html::a($appointment->salon->name, '/site/web/index.php/executor-map/salon-view?id=' . $appointment->salon_id) :
            Html::a($appointment->user->profile->name . ' ' . $appointment->user->profile->surname, '/site/web/index.php/executor-map/user-view?id=' . $appointment->user_id); ?>
        <?php if ($appointment->status == \common\models\Appointment::STATUS_CONFIRMED): ?>
            <span class="uk-label uk-label-success">Подтверждено</span>
        <?php else: ?>
            <span class="uk-label uk-label-warning">Не подтверждено</span>
        <?php endif; ?>
        <a class="uk-accordion-title" href="#">
            <?php echo $appointment->start_date; ?>
        </a>
        <div class="uk-accordion-content">
            <a id="js-modal-confirm"
               class="uk-button uk-button-danger uk-button-small uk-border-rounded uk-float-right"
               href="<?= Url::to(['lk/appointment/cancel', 'appointmentId' => $appointment->id]) ?>">
                Отменить сеанс
            </a>

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
<?php endforeach; ?>
