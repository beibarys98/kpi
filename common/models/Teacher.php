<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%teacher}}".
 *
 * @property int $id
 * @property int $cafedra_id
 * @property int $user_id
 * @property string|null $degree
 * @property string|null $position
 * @property float|null $score
 *
 * @property Cafedra $cafedra
 * @property User $user
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%teacher}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cafedra_id', 'user_id'], 'required'],
            [['cafedra_id', 'user_id'], 'integer'],
            [['score'], 'number'],
            [['degree', 'position'], 'string', 'max' => 255],
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
            'degree' => Yii::t('app', 'Degree'),
            'position' => Yii::t('app', 'Position'),
            'score' => Yii::t('app', 'Score'),
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
     * @return \common\models\query\TeacherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TeacherQuery(get_called_class());
    }
}
