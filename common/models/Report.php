<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%report}}".
 *
 * @property int $id
 * @property string|null $title
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ReportQuery(get_called_class());
    }
}
