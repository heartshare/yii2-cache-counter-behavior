<?php
use Codeception\Util\Stub;

require_once 'tests/models/Post.php';
require_once 'tests/models/Comment.php';


class BehaviorTest extends \Codeception\TestCase\Test
{
    public function testCounterIncrementsAndDecrementsWhen()
    {
        $post_with_comments = new Post();
        $post_with_comments->title = 'post 1';
        $this->assertTrue($post_with_comments->save());

        $post_without_comments = new Post();
        $post_without_comments->title = 'post 2';
        $this->assertTrue($post_without_comments->save());

        //Create 10 comments, ensure counter increments
        for ($i = 1; $i <= 10; $i++) {
            $comment = new Comment();
            $comment->postId  = $post_with_comments->id;
            $comment->text    = 'comment ' . $i;
            $this->assertTrue($comment->save());

            $post_with_comments->refresh();
            $post_without_comments->refresh();

            $this->assertEquals($post_with_comments->comments_count, $i);
            $this->assertEquals($post_without_comments->comments_count, 0);
        }

        //Delete all comments, ensure counter decrements
        $comments = Comment::find()->all();
        $count    = count($comments);

        foreach ($comments as $comment) {
            $this->assertEquals($comment->delete(), 1);
            $count--;
            $post_with_comments->refresh();
            $this->assertEquals($post_with_comments->comments_count, $count);
        }
    }
}