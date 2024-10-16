<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%highschool}}".
 *
 * @property int $id
 * @property int $year
 * @property string|null $title
 * @property float|null $score
 * @property float|null $average
 *
 * @property Cafedra[] $cafedras
 * @property Dekan[] $dekans
 */
class Highschool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%highschool}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['score', 'average'], 'number'],
            ['score', 'default', 'value' => 0],
            ['average', 'default', 'value' => 0]
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
            'score' => Yii::t('app', 'Score'),
            'average' => Yii::t('app', 'Average'),
        ];
    }

    /**
     * Gets query for [[Cafedras]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\CafedraQuery
     */
    public function getCafedras()
    {
        return $this->hasMany(Cafedra::class, ['hs_id' => 'id']);
    }

    /**
     * Gets query for [[Dekans]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\DekanQuery
     */
    public function getDekans()
    {
        return $this->hasMany(Dekan::class, ['hs_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\HighschoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\HighschoolQuery(get_called_class());
    }
}
