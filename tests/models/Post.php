<?php
/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 */

class Post extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'posts';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['title', 'required'],
			['title', 'string', 'max' => 200],
            ['comments_count', 'default', 'value' => 0]
        ];
	}

	/**
	 * @inheritdoc
	 */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'title' => 'Title',
        ];
    }


    public function getComments()
    {
        return $this->hasMany('ostapetc\Yii2CacheCounterBehavior\tests\models', ['postId' => 'id']);
    }
}
