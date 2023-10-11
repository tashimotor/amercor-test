<?php

namespace app\widgets\HistoryList\renderers;

use app\models\History;
use app\models\Sms;
use app\widgets\HistoryList\entities\HistoryListItemCommonParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;
use Yii;

class HistoryListItemSMSRenderer implements HistoryListItemRenderer
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getParams(History $history): HistoryListItemCommonParamsEntity
    {
        $sms = $history->sms;

        return new HistoryListItemCommonParamsEntity(
            body: $sms?->message,
            user: $history->user,
            iconClass: 'icon-sms bg-dark-blue',
            footerDatetime: $history->ins_ts,
            iconIncome: $sms?->direction === Sms::DIRECTION_INCOMING,
            footer: match ($sms?->direction) {
                Sms::DIRECTION_INCOMING => Yii::t(
                    'app',
                    'Incoming message from {number}',
                    ['number' => $sms?->phone_from ?? '']
                ),
                Sms::DIRECTION_OUTGOING => Yii::t(
                    'app',
                    'Sent message to {number}',
                    ['number' => $model->sms?->phone_to ?? '']
                ),
                default => null
            }
        );
    }

    public function getBody(History $history): string
    {
        return $history->sms?->message ?? '';
    }
}
