<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $status
 */
class Region extends \yii\db\ActiveRecord
{

    const STATUS_MAIN = 0;
    const STATUS_SECONDARY = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['created_at', 'updated_at', 'status'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * Получение статусов регионов.
     * @return int[]
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_MAIN => 'Main',
            self::STATUS_SECONDARY => 'Secondary'
        ];
    }

    /**
     * Получение название статусов.
     * @param $status
     * @return string
     */
    public static function getStatusNames($status)
    {
        switch ($status){
            case self::STATUS_MAIN:
                return 'Main';
                break;
            case self::STATUS_SECONDARY:
                return 'Secondary';
                break;
        }
    }
}
