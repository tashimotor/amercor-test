<?php

namespace app\components\PolymorphRelation;

use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class PolymorphRelationMapFactory
{
    /**
     * @var array<string, PolymorphRelationMap>
     */
    protected array $maps = [];

    /**
     * @param  array<class-string, array<class-string>  $polymorphMap
     */
    public function __construct(public array $polymorphMap = [])
    {
        // Nothing
    }

    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function getPolymorphRelationMap(string $class): PolymorphRelationMap
    {
        if (!ArrayHelper::keyExists($class, $this->maps)) {
            $relatedModels = ArrayHelper::getValue($this->polymorphMap, $class);
            if (!$relatedModels === null) {
                throw new InvalidConfigException('No polymorph relations configured for '.$class);
            }

            $this->maps[$class] = Yii::createObject(PolymorphRelationMap::class, [$relatedModels]);
        }


        return $this->maps[$class];
    }
}
