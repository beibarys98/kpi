<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%et_ctg}}".
 *
 * @property int $id
 * @property int $expert_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Expert $expert
 */
class EtCtg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%et_ctg}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expert_id', 'category_id'], 'required'],
            [['expert_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['expert_id'], 'exist', 'skipOnError' => true, 'targetClass' => Expert::class, 'targetAttribute' => ['expert_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'expert_id' => Yii::t('app', 'Expert ID'),
            'category_id' => Yii::t('app', 'Category ID'),
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
     * Gets query for [[Expert]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ExpertQuery
     */
    public function getExpert()
    {
        return $this->hasOne(Expert::class, ['id' => 'expert_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\EtCtgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\EtCtgQuery(get_called_class());
    }
}
