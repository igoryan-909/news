<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 20.06.2017
 * Time: 15:00
 */

namespace app\components\grid;


use yii\helpers\Html;

class GridView extends \yii\grid\GridView
{
    /**
     * @var array
     */
    public $sizes = [10, 25, 50];
    /**
     * @var array
     */
    public $summaryOptions = [
        'class' => 'pull-left',
    ];


    /**
     * @param string $name
     * @return bool|string
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{summary}':
                return $this->renderSummary();
            case '{sizer}':
                return $this->renderSizer();
            case '{items}':
                return $this->renderItems();
            case '{pager}':
                return $this->renderPager();
            case '{sorter}':
                return $this->renderSorter();
            default:
                return false;
        }
    }

    /**
     * @return string
     */
    public function renderSizer()
    {
        $links = [];
        foreach ($this->sizes as $size) {
            $links[] = Html::a($size, ['', 'per-page' => $size]);
        }

        return Html::tag('div', \Yii::t('app', 'Выводить по: {items}', ['items' => implode(', ', $links)]), [
            'class' => 'pull-right',
        ]);
    }
}
