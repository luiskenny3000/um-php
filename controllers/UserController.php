<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\db\Query;
use app\models\User;

class UserController extends ActiveController
{
	public $modelClass = 'app\models\User';
	
	public function behaviors()
	{
		return [
			[
				'class' => ContentNegotiator::className(),
				'only' => ['index', 'view'],
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
				],
			],
		];
	}
	
	public function actionGetusers(){
		$lista = json_decode( $_POST["cellphones"] );
		//print_r( json_decode( $_GET["cellphones"] ) );
		$listaInterseccion = array();
		$usuario = null;
		
		for($i=0; $i<count($lista); $i++){
			$usuario = User::find()->where("celphone=:celphone", [":celphone" => $lista[$i]])->one();
			if( $usuario != null ){
				array_push($listaInterseccion, 
					['celphone'=>$usuario->celphone, 
					 'name'=>$usuario->name,
					 'photo'=>$usuario->photo,
					 'state'=>$usuario->state,
				]);
			}
			$usuario=null;
		}
		
		return json_encode($listaInterseccion);
	}
	
	/*
    public function actionIndex()
    {
        return $this->render('index');
    }
	*/
}
