<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%link}}".
 *
 * @property int $id
 * @property int|null $file_id
 * @property string|null $link
 *
 * @property File $file
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['link'], 'url'],

            [['file_id'], 'integer'],
            [['link'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FileQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\LinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LinkQuery(get_called_class());
    }
}
