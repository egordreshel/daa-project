<?php

namespace common\models;

use backend\models\PrisonerActivity;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;

    const GROUP_GUEST = 0;
    const POSITION_DIRECTOR = 255;
    const POSITION_SECOND_DIRECTOR = 256;
    const POSITION_WORKER = 1;
    const POSITION_PRISONER = 666;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            [['name', 'second_name'], 'required'],
            [['created_at', 'updated_at', 'region_id', 'password'], 'default', 'value' => null],
            ['password', 'default', 'value' => 'prisoner'],
            [['created_at', 'updated_at', 'region_id'], 'integer'],
            [['time'], 'safe'],
            [['username', 'password_hash', 'name', 'second_name', 'position', 'token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'name' => 'Name',
            'second_name' => 'Second Name',
            'position' => 'Position',
            'token' => 'Identity code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'region_id' => 'Region ID',
        ];
    }


    /**
     * Gets query for [[PrisonerActivities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrisonerActivities()
    {
        return $this->hasMany(PrisonerActivity::className(), ['prisoner_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**Получить пользователя по токену
     * @param string $token
     * @return bool
     */
    public static function getByToken($token)
    {
        $user = self::findOne(['token' => $token]);
        return Yii::$app->user->login($user, 300);
    }


    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Событие перед сохранением.
     * @param bool $insert признак вставки(true)/обновления(false)
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);
        if ($this->password) {
            self::setPassword($this->password);
        }
        $this->generateAuthKey();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Получение статусов регионов.
     * @return int[]
     */
    public static function getPosition()
    {
        return [
            self::POSITION_WORKER => 'Worker',
            self::POSITION_SECOND_DIRECTOR => 'Second director',
        ];
    }

    /**
     * Получение название статусов.
     * @param $status
     * @return string
     */
    public static function getPositionNames($status)
    {
        switch ($status) {
            case self::POSITION_SECOND_DIRECTOR:
            case self::POSITION_DIRECTOR:
                return 'Director';
                break;
            case self::POSITION_PRISONER:
                return 'Prisoner';
                break;
            case self::POSITION_WORKER:
                return 'Worker';
                break;
        }
    }

    /**
     * Вывод имени и фамилии.
     * @return string
     */
    public function getFullName()
    {
        return $this->name . " " . $this->second_name;
    }
}
