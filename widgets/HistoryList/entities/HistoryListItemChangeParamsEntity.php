<?php

namespace app\widgets\HistoryList\entities;

use app\models\History;
use app\widgets\HistoryList\interfaces\HistoryListItemParams;

readonly class HistoryListItemChangeParamsEntity implements HistoryListItemParams
{
    public function __construct(
        public History $history,
        public ?string $oldValue = null,
        public ?string $newValue = null,
    ) {
        // Nothing
    }
}
