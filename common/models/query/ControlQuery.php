<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Control]].
 *
 * @see \common\models\Control
 */
class ControlQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Control[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Control|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
