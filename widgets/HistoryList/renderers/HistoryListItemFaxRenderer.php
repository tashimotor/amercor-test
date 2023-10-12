<?php

namespace app\widgets\HistoryList\renderers;

use app\models\History;
use app\widgets\HistoryList\entities\HistoryListItemCommonParamsEntity;
use app\widgets\HistoryList\interfaces\HistoryListItemRenderer;
use Yii;
use yii\helpers\Html;

class HistoryListItemFaxRenderer implements HistoryListItemRenderer
{
    public function getTemplate(): string
    {
        return '_item_common';
    }

    public function getParams(History $history): HistoryListItemCommonParamsEntity
    {
        $fax = $history->fax;

        return new HistoryListItemCommonParamsEntity(
            body: $this->getBody($history),
            user: $history->user,
            iconClass: 'fa-fax bg-green',
            footerDatetime: $history->ins_ts,
            footer: Yii::t('app', '{type} was sent to {group}', [
                'type'  => $fax !== null ? $fax->getTypeText() : 'Fax',
                'group' => isset($fax?->creditorGroup) ? Html::a($fax->creditorGroup->name,
                    ['creditors/groups'], ['data-pjax' => 0]) : ''
            ])
        );
    }

    public function getBody(History $history): string
    {
       return $history->eventText.' - '.
           (isset($fax?->document) ? Html::a(
               Yii::t('app', 'view document'),
               $fax?->document->getViewUrl(),
               [
                   'target'    => '_blank',
                   'data-pjax' => 0
               ]
           ) : '');
    }
}
