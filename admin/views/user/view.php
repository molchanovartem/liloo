<?php

use yii\helpers\Html;
use admin\widgets\detailView\DetailView;

$this->setTitle($model->login);

$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'uk-button uk-button-default uk-button-small']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'uk-button uk-button-danger uk-button-small',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <div class="uk-child-width-1-2">
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'login',
                'role',
            ],
        ])
        ?>
    </div>

    <div class="uk-grid uk-child-width-1-3@m uk-grid-small uk-grid-match" >
        <?php foreach ($interactions as $interaction): ?>
        <div>
            <div class="uk-card uk-card-primary uk-card-body uk-card-small uk-width-1-2 uk-border-rounded">
                <p><?php echo $interaction->comment; ?></p>
                <p class="uk-text-right">
                    <sub><?php echo Yii::$app->formatter->format($interaction->created_at, 'date'); ?></sub>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php

    use admin\widgets\activeForm\ActiveForm;

    ?>

<!--    <div class="user-form">-->
<!---->
<!--        --><?php //$form = ActiveForm::begin(['action' => ['user/createInteraction'],'options' => ['method' => 'post']]) ?>
<!--        <div class="panel panel-default panel-body">-->
<!---->
<!--            --><?//= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>
<!---->
<!--            --><?//= $form->field($model, 'comment')->textarea(['rows' => '6']) ?>
<!---->
<!--            --><?//= $form->field($model, 'role')->dropDownList(['0' => 'Суперадмин', '1' => 'Админ'], ['prompt' => 'Выберите роль...']); ?>
<!---->
<!--        </div>-->
<!---->
<!--        --><?php //ActiveForm::end(); ?>
<!---->
<!--    </div>-->


</div>
