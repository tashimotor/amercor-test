<?php

namespace app\widgets\HistoryList\interfaces;

use app\models\History;

interface HistoryListItemRenderer
{
    public function getParams(History $history): HistoryListItemParams;

    public function getTemplate(): string;

    public function getBody(History $history): string;
}
