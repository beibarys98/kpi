<?php

namespace common\models\query;

use common\models\File;

/**
 * This is the ActiveQuery class for [[\common\models\File]].
 *
 * @see \common\models\File
 */
class FileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\File[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\File|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
