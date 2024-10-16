<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%criteria}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $number
 * @property string|null $criteria
 * @property string|null $criteria_kz
 * @property string|null $unit
 * @property int|null $points
 * @property string|null $condition
 *
 * @property Category $category
 * @property File[] $files
 */
class Criteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%criteria}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'points'], 'integer'],
            [['number', 'unit', 'condition'], 'string', 'max' => 255],
            [['criteria', 'criteria_kz'], 'string', 'max' => 10000],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'number' => Yii::t('app', 'Number'),
            'criteria' => Yii::t('app', 'Criteria'),
            'unit' => Yii::t('app', 'Unit'),
            'points' => Yii::t('app', 'Points'),
            'condition' => Yii::t('app', 'Condition'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FileQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['criteria_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CriteriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CriteriaQuery(get_called_class());
    }
}
