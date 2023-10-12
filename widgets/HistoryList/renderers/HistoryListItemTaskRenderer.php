<?php

namespace app\widgets\HistoryList\renderers;

use app\models\History;
use app\widgets\HistoryList\entities\HistoryListItemCommonParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;

class HistoryListItemTaskRenderer implements HistoryListItemRenderer
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getParams(History $history): HistoryListItemCommonParamsEntity
    {
        $task = $history->task;

        return new HistoryListItemCommonParamsEntity(
            body: $this->getBody($history),
            user: $history->user,
            iconClass: 'fa-check-square bg-yellow',
            footerDatetime: $history->ins_ts,
            footer: isset($task?->customerCreditor->name)
                ? "Creditor: ".$task?->customerCreditor->name
                : null
        );
    }

    public function getBody(History $history): string
    {
        return "$history->eventText : ".($history?->task?->title ?? '');
    }
}
