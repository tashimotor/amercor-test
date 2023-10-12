<?php

namespace app\components\PolymorphRelation;

use InvalidArgumentException;
use yii\helpers\ArrayHelper;

class PolymorphRelationMap
{
    /**
     * @var array<string, class-string>
     */
    protected array $relationMap = [];

    /**
     * @param  array<class-string>  $relatedModelClasses
     */
    public function __construct(protected array $relatedModelClasses = [])
    {
        // Nothing
    }

    /**
     * @return string[]
     */
    public function getRelationTableNames(): array
    {
        return array_keys($this->getRelationMap());
    }

    /**
     * @return array<string, class-string>
     */
    public function getRelationMap(): array
    {
        if (count($this->relationMap) === 0) {
            array_walk(
                $this->relatedModelClasses,
                function (string $relatedModelClass) {
                    if (!method_exists($relatedModelClass, 'tableName')) {
                        throw new InvalidArgumentException($relatedModelClass.' must have tableName() method');
                    }
                    ArrayHelper::setValue(
                        $this->relationMap,
                        str_replace(['{', '}', '%'], '', $relatedModelClass::tableName()),
                        $relatedModelClass
                    );
                }
            );
        }

        return $this->relationMap;
    }
}
