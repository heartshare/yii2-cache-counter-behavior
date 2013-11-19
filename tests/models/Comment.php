<?php
/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $postId
 * @property string $text
 */

require_once 'Behavior.php';


class Comment extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'comments';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['postId'], 'integer'],
			[['text', 'postId'], 'required'],
			[['text'], 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'postId' => 'Post ID',
			'text' => 'Text'
		];
	}


    public function behaviors()
    {
        return [
            'cacheCounters' => [
                'class'    => 'ostapetc\Yii2CacheCounterBehavior\Behavior',
                'counters' => [
                    [
                        'model'      => 'Post',
                        'attribute'  => 'comments_count',
                        'foreignKey' => 'postId'
                    ]
                ]
            ]
        ];
    }
}
