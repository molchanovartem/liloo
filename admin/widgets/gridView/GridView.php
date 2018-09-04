<?php

namespace admin\widgets\gridView;


use Yii;
use yii\helpers\Html;

/**
 * Class GridView
 * @package app\modules\lk\widgets\grid
 */
class GridView extends \yii\grid\GridView
{
    /**
     * @var array
     */
    public $tableOptions = [
        'class' => 'uk-table uk-table-divider uk-table-small uk-table-hover'
    ];
    /**
     * @var string
     */
    public $dataColumnClass = 'admin\widgets\gridView\DataColumn';
    /**
     * @var string
     */
    public $toolbarWidgetClass = 'admin\widgets\Menu';
    /**
     * @var array
     */
    public $toolbar = [];
    /**
     * @var string
     */
    public $toolbarCssClass = 'uk-subnav uk-margin-remove-bottom';
    /**
     * @var array
     */
    public $buttonOptions = [];
    /**
     * @var string
     */
    public $layout = "{toolbar}\n{summary}\n{items}\n{pager}";
    /**
     * @var array
     */
    public $summaryOptions = ['class' => 'summary pull-right'];

    public function renderSection($name)
    {
        switch ($name) {
            case '{toolbar}':
                return $this->rendertoolbar();
            default:
                return parent::renderSection($name);
        }
    }

    protected function initColumns()
    {
        array_unshift($this->columns, $this->getSerialColumn());

        // добавляем стиль, если есть коллонка id
        if ($keyId = array_search('id', $this->columns)) {
            $this->columns[$keyId] = [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 5%'],
            ];
        }
        parent::initColumns();
    }

    /**
     * @return null|string
     * @throws \yii\base\InvalidConfigException
     */
    protected function rendertoolbar()
    {
        if (empty($this->toolbar['items'])) {
            return null;
        }

        if (!isset($this->toolbar['options'])) {
            $this->toolbar['options'] = [];
        }
        Html::addCssClass($this->toolbar['options'], $this->toolbarCssClass);

        return Yii::createObject($this->toolbarWidgetClass)
            ->widget($this->toolbar);
    }

    /**
     * @return array
     */
    protected function getSerialColumn(): array
    {
        return [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['style' => 'width: 3%;'],
        ];
    }
}
