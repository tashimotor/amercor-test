<?php

namespace app\widgets\HistoryList;

use app\models\History;
use kartik\export\ExportMenu;
use Yii;

class HistoryListExport extends ExportMenu
{
    public $exportType = self::FORMAT_CSV;

    public function init()
    {
        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (empty($this->exportRequestParam)) {
            $this->exportRequestParam = 'exportFull_'.$this->options['id'];
        }

        $_POST[Yii::$app->request->methodParam] = 'POST';
        $_POST[$this->exportRequestParam]       = true;
        $_POST[$this->exportTypeParam]          = $this->exportType;
        $_POST[$this->colSelFlagParam]          = false;

        parent::init();
    }

    public static function renderMessage(History $history): string
    {
        return (new HistoryListEventRendererFactory())
            ->getRenderer($history->event)
            ->getBody($history);
    }
}
