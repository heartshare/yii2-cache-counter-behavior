<?php
/**
 * Created by PhpStorm.
 * User: os
 * Date: 20.11.13
 * Time: 16:20
 */
namespace ostapetc\yii2\console\controllers;

use yii\base\Exception;
use Yii;
use yii\base\UnknownClassException;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\helpers\Console;
use ostapetc\yii2\behaviors\CounterCacheBehavior;


class UpdateCacheCountersController extends Controller
{
    public function actionIndex($modelClass)
    {
        /**
         * @var ActiveRecord $model
         */
        if (!class_exists($modelClass)) {
            throw new UnknownClassException("class {$modelClass} not found");
        }

        $model    = new $modelClass;
        $behavior = null;

        foreach ($model->behaviors as $name => $someBehavior) {
            if ($someBehavior instanceof CounterCacheBehavior) {
                $behavior = $someBehavior;
                break;
            }
        }

        if (!$behavior) {
            throw new Exception("Behavior CounterCacheBehavior not found in class {$modelClass}");
        }

        foreach ($behavior->counters as $params) {
            $count_data = $model::find()->select("{$params['foreignKey']}, count(*) as total_count")->asArray()->all();
            foreach ($count_data as $data) {
                $updated = $params['model']::updateAll([$params['attribute'] => $data['total_count']], ['id' => $data[$params['foreignKey']]]);
                if ($updated) {
                    $message = "{$params['model']} updated with id {$data[$params['foreignKey']]}";
                    $this->stdout("\n{$message}.\n\n", Console::BG_GREEN);
                }
            }
        }
    }
} 