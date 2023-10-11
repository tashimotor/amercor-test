<?php

namespace app\widgets\HistoryList\entities;

use app\models\User;
use app\widgets\HistoryList\interfaces\HistoryListItemParams;

readonly class HistoryListItemCommonParamsEntity implements HistoryListItemParams
{
    public function __construct(
        public ?string $body = null,
        public ?User $user = null,
        public ?string $content = null,
        public ?string $iconClass = null,
        public ?string $footerDatetime = null,
        public ?string $bodyDatetime = null,
        public ?bool $iconIncome = null,
        public ?string $footer = null,
    ) {
        // Nothing
    }
}
