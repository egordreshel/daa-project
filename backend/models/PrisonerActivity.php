<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "prisoner_activity".
 *
 * @property int $id
 * @property int $prisoner_id
 * @property string|null $penalty Penalty
 * @property string|null $privileges Privileges
 */
class PrisonerActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prisoner_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prisoner_id'], 'required'],
            [['prisoner_id'], 'default', 'value' => null],
            [['prisoner_id'], 'integer'],
            [['penalty', 'privileges'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prisoner_id' => 'Prisoner ID',
            'penalty' => 'Penalty',
            'privileges' => 'Privileges',
        ];
    }

    /**
     * Gets query for [[Prisoner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrisoner()
    {
        return $this->hasOne(User::className(), ['id' => 'prisoner_id']);
    }
}
