Yii2CacheCounterBehavior
========================

DESCRIPTION
-------------
If you need to display the record count for a has_many association, you can improve performance by caching that number in a column.

EXAMPLE
-------------
We have "Post" and "Comment" models, "Post" has many "Comment":

```
class Post extends \yii\db\ActiveRecord
{
    public function getComments()
    {
        return $this->hasMany('Comment', ['postId' => 'id']);
    }
}
```

```
class Comment extends \yii\db\ActiveRecord
{
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
                        'attribute'  => 'commentsCount',
                        'foreignKey' => 'postId'
                    ]
                ]
            ]
        ];
    }
}
```

```
$comment = new Comment();
$comment->postId = 1;
$comment->text   = 'blabla';
$comment->save();

$post = Post::find(1);
echo $post->commentsCount; # will display 1
```

NOTICE
-------------
1) commentsCount counter will not be updated if you use deleteAll, updateAll methods.

2) If you already have data in tables you should run console controller command to update counters.
Add controller to config/console.php controller map:
```
'controllerMap' => [
    'UpdateCacheCounters' => 'ostapetc\yii2\console\controllers\UpdateCacheCountersController'
]
```

and run:
```
./yii UpdateCacheCounters app\\models\\Comment
```

