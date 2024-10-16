<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property int $id
 * @property int $criteria_id
 * @property string|null $file
 * @property string|null $desc
 * @property string|null $file_path
 * @property string|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property Criteria $criteria
 */
class File extends \yii\db\ActiveRecord
{
    public $newFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['newFile'], 'required'],

            [['criteria_id'], 'required'],
            [['criteria_id', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['file', 'desc', 'file_path', 'status'], 'string', 'max' => 255],
            [['criteria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Criteria::class, 'targetAttribute' => ['criteria_id' => 'id']],

            [['newFile'], 'file', 'extensions' => 'pdf']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'criteria_id' => Yii::t('app', 'Criteria ID'),
            'file' => Yii::t('app', 'File'),
            'desc' => Yii::t('app', 'Desc'),
            'file_path' => Yii::t('app', 'File Path'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }

    /**
     * Gets query for [[Criteria]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CriteriaQuery
     */
    public function getCriteria()
    {
        return $this->hasOne(Criteria::class, ['id' => 'criteria_id']);
    }

    public function getUser(){
        return User::find()->andWhere(['id' => $this->created_by])->one();
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\FileQuery(get_called_class());
    }
}
