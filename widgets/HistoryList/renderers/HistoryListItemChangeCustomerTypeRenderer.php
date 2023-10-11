<?php

namespace app\widgets\HistoryList\renderers;

use app\models\Customer;
use app\models\History;
use app\widgets\HistoryList\entities\HistoryListItemChangeParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;

class HistoryListItemChangeCustomerTypeRenderer implements HistoryListItemRenderer
{
    public function getTemplate(): string
    {
        return '_item_change';
    }

    public function getParams(History $history): HistoryListItemChangeParamsEntity
    {
        return new HistoryListItemChangeParamsEntity(
            history: $history,
            oldValue: Customer::getTypeTextByType($history->getDetailOldValue('type')),
            newValue: Customer::getTypeTextByType($history->getDetailNewValue('type'))
        );
    }

    public function getBody(History $history): string
    {
        return "$history->eventText ".
            (Customer::getTypeTextByType($history->getDetailOldValue('type')) ?? "not set").' to '.
            (Customer::getTypeTextByType($history->getDetailNewValue('type')) ?? "not set");
    }
}
