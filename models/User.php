<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $celphone
 * @property string $name
 * @property resource $photo
 * @property string $password
 * @property string $state
 *
 * @property Message[] $messages
 * @property Message[] $messages0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['celphone', 'name', 'photo', 'password', 'state'], 'required'],
            [['photo'], 'string'],
            [['celphone'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 40],
            [['state'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'celphone' => 'Celphone',
            'name' => 'Name',
            'photo' => 'Photo',
            'password' => 'Password',
            'state' => 'State',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['transmitter' => 'celphone']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['receiver' => 'celphone']);
    }
}
