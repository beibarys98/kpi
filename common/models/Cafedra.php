<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%cafedra}}".
 *
 * @property int $id
 * @property int $hs_id
 * @property string|null $cafedra
 *
 * @property Highschool $hs
 * @property Manager[] $managers
 * @property Teacher[] $teachers
 */
class Cafedra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cafedra}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hs_id'], 'required'],
            [['hs_id'], 'integer'],
            [['cafedra'], 'string', 'max' => 255],
            [['cafedra'], 'unique'],
            [['hs_id'], 'exist', 'skipOnError' => true, 'targetClass' => Highschool::class, 'targetAttribute' => ['hs_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hs_id' => Yii::t('app', 'Hs ID'),
            'cafedra' => Yii::t('app', 'Cafedra'),
        ];
    }

    /**
     * Gets query for [[Hs]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\HighschoolQuery
     */
    public function getHighschool()
    {
        return $this->hasOne(Highschool::class, ['id' => 'hs_id']);
    }

    /**
     * Gets query for [[Managers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ManagerQuery
     */
    public function getManagers()
    {
        return $this->hasMany(Manager::class, ['cafedra_id' => 'id']);
    }

    /**
     * Gets query for [[Teachers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\TeacherQuery
     */
    public function getTeachers()
    {
        return $this->hasMany(Teacher::class, ['cafedra_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CafedraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CafedraQuery(get_called_class());
    }
}
