<?php
/**
 * Created by PhpStorm.
 * User: liuzhiwei
 * Date: 2016/4/19
 * Time: 13:53
 */
use yii\helpers\Html;
?>
<ul>
    <li><label><?php echo $model->name; ?></label></li>
    <li><label><?=Html::encode($model->pass)?></label></li>
</ul>