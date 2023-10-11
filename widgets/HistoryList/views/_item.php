<?php

use app\models\search\HistorySearch;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use app\widgets\HistoryList\HistoryListEventRendererFactory;

/** @var $model HistorySearch */
$renderer = (new HistoryListEventRendererFactory())->getRenderer($model->event);

echo $this->render(
    $renderer->getTemplate(),
    (array) $renderer->getParams($model)
);
