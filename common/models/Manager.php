<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%manager}}".
 *
 * @property int $id
 * @property int $cafedra_id
 * @property int $user_id
 *
 * @property Cafedra $cafedra
 * @property User $user
 */
class Manager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%manager}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cafedra_id', 'user_id'], 'required'],
            [['cafedra_id', 'user_id'], 'integer'],
            [['cafedra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cafedra::class, 'targetAttribute' => ['cafedra_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cafedra_id' => Yii::t('app', 'Cafedra ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * Gets query for [[Cafedra]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CafedraQuery
     */
    public function getCafedra()
    {
        return $this->hasOne(Cafedra::class, ['id' => 'cafedra_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ManagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ManagerQuery(get_called_class());
    }
}
