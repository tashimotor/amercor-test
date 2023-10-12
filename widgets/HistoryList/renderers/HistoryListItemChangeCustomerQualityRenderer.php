<?php

namespace app\widgets\HistoryList\renderers;

use app\models\Customer;
use app\models\History;
use app\widgets\HistoryList\entities\HistoryListItemChangeParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;

class HistoryListItemChangeCustomerQualityRenderer implements HistoryListItemRenderer
{
    public function getTemplate(): string
    {
        return '_item_change';
    }

    public function getParams(History $history): HistoryListItemChangeParamsEntity
    {
        return new HistoryListItemChangeParamsEntity(
            history: $history,
            oldValue: Customer::getQualityTextByQuality($history->getDetailOldValue('quality')),
            newValue: Customer::getQualityTextByQuality($history->getDetailOldValue('quality'))
        );
    }

    public function getBody(History $history): string
    {
        return "$history->eventText ".
            (Customer::getQualityTextByQuality($history->getDetailOldValue('quality')) ?? "not set").' to '.
            (Customer::getQualityTextByQuality($history->getDetailNewValue('quality')) ?? "not set");
    }
}
