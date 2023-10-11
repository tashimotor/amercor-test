<?php

namespace app\models\traits;

use app\components\PolymorphRelation\PolymorphRelationMap;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveQueryInterface;
use yii\helpers\ArrayHelper;

trait WithPolymorphRelationsTrait
{
    /**
     * @throws InvalidConfigException
     */
    protected static function getPolymorphRelationMap(): PolymorphRelationMap
    {
        return Yii::$app->get('polymorphRelation')->getPolymorphRelationMap(self::class);
    }

    /**
     * @return array
     * @throws InvalidConfigException
     */
    public static function getPolymorphRelationTableNames(): array
    {
        return self::getPolymorphRelationMap()->getRelationTableNames();
    }

    /**
     * @param $name
     * @param  bool  $throwException
     *
     * @return ActiveQuery|ActiveQueryInterface|null
     * @throws Exception
     */
    public function getRelation($name, $throwException = true)
    {
        $getter       = 'get'.$name;
        $relatedClass = ArrayHelper::getValue(self::getPolymorphRelationMap()->getRelationMap(), $name);

        if (!method_exists($this, $getter) && $relatedClass !== null) {
            return $this->hasOne($relatedClass, ['id' => 'object_id']);
        }

        return parent::getRelation($name, $throwException);
    }
}
