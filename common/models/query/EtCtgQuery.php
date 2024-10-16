<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\EtCtg]].
 *
 * @see \common\models\EtCtg
 */
class EtCtgQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\EtCtg[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\EtCtg|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
