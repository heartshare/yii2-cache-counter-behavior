<?php
/**
 * Created by PhpStorm.
 * User: os
 * Date: 19.11.13
 * Time: 13:10
 */

namespace ostapetc\yii2\behaviors;

use yii\base\InvalidParamException;
use yii\db\ActiveRecord;


class CounterCacheBehavior extends \yii\base\Behavior
{
    public $counters;


    public function init()
    {
        if (!is_array($this->counters)) {
            throw new InvalidParamException('counters property should be array');
        }
        return parent::init();
    }


    public function events()
    {
        return array(
            ActiveRecord::EVENT_BEFORE_DELETE => 'afterDelete',
            ActiveRecord::EVENT_BEFORE_INSERT => 'afterInsert',
        );
    }


    public function afterInsert()
    {
        $this->updateCounters(1);
    }


    public function afterDelete()
    {
        $this->updateCounters(-1);
    }


    private function updateCounters($value)
    {
        foreach ($this->counters as $params) {
            if (!$this->owner->$params['foreignKey']) {
                continue;
            }
            $params['model']::updateAllCounters([$params['attribute'] => $value], ['id' => $this->owner->$params['foreignKey']]);
        }
    }
} 