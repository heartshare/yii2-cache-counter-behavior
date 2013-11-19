Yii2CacheCounterBehavior
========================

DOCUMENTATION
-------------
If you need to display the record count for a has_many association, you can improve performance by caching that number in a column.

EXAMPLE
-------------
We have "Post" and "Comment" models, "Post" has many "Comment":

class Post extends \yii\db\ActiveRecord
{
    public function getComments()
    {
        return $this->hasMany('Comment', ['postId' => 'id']);
    }
}

class Comment extends \yii\db\ActiveRecord
{
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

$comment = new Comment();
$comment->postId = 1;
$comment->text   = 'blabla';
$comment->save();

$post = Post::find(1);
echo $post->comments_count; # will display 1
