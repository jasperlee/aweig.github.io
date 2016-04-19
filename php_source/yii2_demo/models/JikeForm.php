<?php
/**
 * Created by PhpStorm.
 * User: liuzhiwei
 * Date: 2016/4/19
 * Time: 11:41
 */
namespace app\models;
use Yii;
use yii\base\Model;

class JikeForm extends Model{
    public $name;
    public $pass;
    public $email;
    public $sex;
    public $edu;
    public $hobby;
    public $info;

    public function rules(){
        /**
         * ['name','url','defaultScheme'=>'http','message'=>'xxx'];
         */
        return [
            [['name','pass','email','sex','edu','hobby','info'],'required'],
            ['email','email','message'=>'必须邮箱'],
            ['name','string','length'=>[2,10]]
        ];
    }

    public function attributelabels(){
        return [
            'name'=>'名称',
            'pass'=>'密码',
            'sex'=>'性别',
            'email'=>'邮箱',
            'edu'=>'教育程度',
            'info'=>'信息'
        ];
    }
}