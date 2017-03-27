<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\db\Query;
use app\models\Message;

class MessageController extends ActiveController
{
	public $modelClass = 'app\models\Message';
	
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
	
	public function actionGetmessage($emisor, $receptor){
		$arreglo = array();
		
		$query = new Query();
		$query->select('*')
			->from('message')
			->where(['transmitter'=>$emisor, 'receiver'=>$receptor]);
		$rows1 = $query->all();
		
		$query = new Query();
		$query->select('*')
			->from('message')
			->where(['transmitter'=>$receptor, 'receiver'=>$emisor]);
		$rows2 = $query->all();
		
		for($i=0; $i<count($rows1); $i++){
			array_push($arreglo, $rows1[$i] );
		}
		for($i=0; $i<count($rows2); $i++){
			array_push($arreglo, $rows2[$i] );
		}
		
		return json_encode($arreglo);
	}
	
	public function actionSetmessage(){
		$model = new Message();
		$model->transmitter = $_POST['transmitter'];
		$model->receiver = $_POST['receiver'];
		$model->text = $_POST['text'];
		$model->date = $_POST['date'];
		$model->type = $_POST['type'];
		
		$model->save();
		/*
		$sql = $queryBuilder->insert('message', [
			'transmitter' => $_POST['transmitter'],
			'receiver' => $_POST['receiver'],
			'text' => $_POST['text'],
			'date' => $_POST['date'],
			'type' => $_POST['type'],
		]);
		*/
	}
	
	
	/*
    public function actionIndex()
    {
        return $this->render('index');
    }
	*/

}
