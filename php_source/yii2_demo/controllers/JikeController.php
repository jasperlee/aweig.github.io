<?php
/**
 * Created by PhpStorm.
 * User: liuzhiwei
 * Date: 2016/4/19
 * Time: 11:35
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\JikeForm;
use app\models\People;
use yii\data\Pagination;

class JikeController extends Controller{

    public function actionIndex(){
        $model = new jikeForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            return $this->render('index-two',['model'=>$model]);
        }else{
            return $this->render('index',['model'=>$model]);
        }
    }

    public function actionPeople(){
        $query = People::find();
        $page = new Pagination([
            'defaultPageSize'=>3,
            'totalCount'=>$query->count(),
        ]);

        $people = $query->orderBy('id')->offset($page->offset)->limit($page->limit)->all();
        return $this->render('people',[
            'people'=>$people,
            'page'=>$page
        ]);
    }
}