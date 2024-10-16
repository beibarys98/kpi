<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%control}}".
 *
 * @property int $id
 * @property int|null $teacher
 * @property int|null $manager
 * @property int|null $expert
 */
class Control extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%control}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher', 'manager', 'expert'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'teacher' => Yii::t('app', 'Teacher'),
            'manager' => Yii::t('app', 'Manager'),
            'expert' => Yii::t('app', 'Expert'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ControlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ControlQuery(get_called_class());
    }
}
