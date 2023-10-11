<?php

namespace app\widgets\HistoryList\renderers;

use app\models\Call;
use app\models\History;
use app\widgets\HistoryList\entities\HistoryListItemCommonParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;

class HistoryListItemCallRenderer implements HistoryListItemRenderer
{
    public function getParams(History $history): HistoryListItemCommonParamsEntity
    {
        $call     = $history->call;
        $answered = $call?->status === Call::STATUS_ANSWERED;

        return new HistoryListItemCommonParamsEntity(
            body: $this->getBody($history),
            user: $history?->user,
            content: $call?->comment,
            iconClass: $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
            footerDatetime: $history->ins_ts,
            iconIncome: $answered && $call?->direction == Call::DIRECTION_INCOMING,
            footer: isset($history->applicant)
                ? "Called <span>{$history->applicant->name}</span>"
                : null
        );
    }

    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getBody(History $history): string
    {
        $call = $history->call;

        return $call === null ? '<i>Deleted</i> ' : ($call->totalStatusText.$call->getTotalDisposition(false)
            ? " <span class='text-grey'>".$call->getTotalDisposition(false)."</span>"
            : "");
    }
}
