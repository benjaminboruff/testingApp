<?php

namespace Tests\Feature;

use App\User;
use App\Post;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    protected $post;

    public function setUp()
    {
        parent::setUp();

        // given I have a post
        $this->post = factory(Post::class)->create();
        // $this->post = createPost();

        // and a signed-in user
        $this->signIn();
    }

    /** @test */
    public function a_user_can_like_a_post()
    {
        // *** when they like the post ***
        $this->post->like();

        // the we should see evidence in the db
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post)
        ]);

        // and the post should be liked
        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        // a post is liked
        $this->post->like();
 
        // *** when they unlike the post ***
        $this->post->unlike();
 
        // the we should see no evidence in the db
        $this->assertDatabaseMissing('likes', [
             'user_id' => $this->user->id,
             'likeable_id' => $this->post->id,
             'likeable_type' => get_class($this->post)
         ]);
 
        // and the post should not be liked
        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_toggle_a_post_like_status()
    {
        // a post is toggled
        $this->post->toggle();
         
        // then the post should be liked
        $this->assertTrue($this->post->isLiked());

        // and if it is toggled again
        $this->post->toggle();
                          
        // the post should not be liked
        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        // a user likes the post
        $this->post->toggle();

        // the post should find how many likes it has
        $this->assertEquals(1, $this->post->likesCount);

        // and a second user
        $user2 = factory(User::class)->create();
         
        // that is logged in
        $this->actingAs($user2);
        
        // and likes the same post
        $this->post->toggle();

        // the post should find how many likes it has
        $this->assertEquals(2, $this->post->likesCount);
    }
}
