<?php

namespace app\widgets\HistoryList;

use app\models\enums\HistoryEventTypeEnum;
use app\models\History;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemCallRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemChangeCustomerQualityRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemChangeCustomerTypeRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemCommonRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemFaxRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemSMSRenderer;
use app\widgets\HistoryList\renderers\HistoryListItemTaskRenderer;

class HistoryListEventRendererFactory
{
    public function getRenderer(HistoryEventTypeEnum $type): HistoryListItemRenderer
    {
        $className = match ($type) {
            HistoryEventTypeEnum::EVENT_CREATED_TASK, HistoryEventTypeEnum::EVENT_COMPLETED_TASK, HistoryEventTypeEnum::EVENT_UPDATED_TASK => HistoryListItemTaskRenderer::class,
            HistoryEventTypeEnum::EVENT_INCOMING_SMS, HistoryEventTypeEnum::EVENT_OUTGOING_SMS => HistoryListItemSMSRenderer::class,
            HistoryEventTypeEnum::EVENT_INCOMING_CALL, HistoryEventTypeEnum::EVENT_OUTGOING_CALL => HistoryListItemCallRenderer::class,
            HistoryEventTypeEnum::EVENT_INCOMING_FAX, HistoryEventTypeEnum::EVENT_OUTGOING_FAX => HistoryListItemFaxRenderer::class,
            HistoryEventTypeEnum::EVENT_CUSTOMER_CHANGE_TYPE => HistoryListItemChangeCustomerTypeRenderer::class,
            HistoryEventTypeEnum::EVENT_CUSTOMER_CHANGE_QUALITY => HistoryListItemChangeCustomerQualityRenderer::class,
            default => HistoryListItemCommonRenderer::class
        };

        return new $className;
    }
}
