<?php

namespace app\widgets\HistoryList\renderers;

use app\models\History;
use app\widgets\HistoryList\entities\HistoryListItemCommonParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;

class HistoryListItemCommonRenderer implements HistoryListItemRenderer
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getParams(History $history): HistoryListItemCommonParamsEntity
    {
        return new HistoryListItemCommonParamsEntity(
            body: $history->eventText,
            user: $history->user,
            iconClass: 'fa-gear bg-purple-light',
            footerDatetime: $history->ins_ts,
            bodyDatetime: $history->ins_ts,
        );
    }

    public function getBody(History $history): string
    {
        return $history->eventText;
    }
}
