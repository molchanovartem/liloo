<button class="uk-button uk-button-default" type="button">Пожаловаться</button>
<div uk-dropdown>
    <?php use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['recall/complaint']),]); ?>

    <?php echo
        $form->field($model, 'reason')->checkboxList(
            ['Меркурий' => 'Меркурий', 'Венера' => 'Венера', 'Земля' => 'Земля']
        )->label('?');
    ?>
    <?php echo Html::submitButton('Отправить', [
        'class' => 'button button_color_red',
        'name' => 'login-button'
    ]); ?>
    <?php ActiveForm::end(); ?>
</div>