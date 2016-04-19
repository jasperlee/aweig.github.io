<?php
/**
 * Created by PhpStorm.
 * User: liuzhiwei
 * Date: 2016/4/19
 * Time: 14:35
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>test</h1>
<ul>
    <?php foreach($people as $v): ?>
    <li>
        <?php echo $v->name; ?>
    </li>
    <?php endforeach ?>
</ul>
<?= LinkPager::widget(['pagination'=>$page])?>
