<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Link]].
 *
 * @see \common\models\Link
 */
class LinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Link[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Link|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
