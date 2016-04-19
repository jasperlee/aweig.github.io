<?php
/**
 * Created by PhpStorm.
 * User: liuzhiwei
 * Date: 2016/4/19
 * Time: 11:51
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model,'name')->textInput(['style'=>'width:200px']);?>
    <?=$form->field($model,'pass')->passwordInput(['style'=>'width:200px;']);?>
    <?=$form->field($model,'email')->textInput(['style'=>'width:200px']);?>
    <?=$form->field($model,'sex')->radioList(['1'=>'男','0'=>'女']);?>
    <?=$form->field($model,'edu')->dropDownList(['1'=>'大学','2'=>'中学','3'=>'小学'],['style'=>'width:200px']);?>
    <?=$form->field($model,'hobby')->checkboxList(['篮球'=>'篮球','排球'=>'排球']);?>
    <?=$form->field($model,'info')->textarea(['style'=>'width:200px']);?>

    <div class="form-group">
        <?=Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
    </div>
<?php $form = ActiveForm::end(); ?>


