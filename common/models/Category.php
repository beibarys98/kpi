<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $category_kz
 * @property int|null $type
 *
 * @property Criteria[] $criterias
 * @property EtCtg[] $etCtgs
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['category', 'category_kz'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * Gets query for [[Criterias]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CriteriaQuery
     */
    public function getCriterias()
    {
        return $this->hasMany(Criteria::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[EtCtgs]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\EtCtgQuery
     */
    public function getEtCtgs()
    {
        return $this->hasMany(EtCtg::class, ['category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CategoryQuery(get_called_class());
    }
}
