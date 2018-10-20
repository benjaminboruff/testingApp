<?php

namespace Tests\Feature;

use App\User;
use App\Post;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_like_a_post()
    {
        // given I have a post
        $post = factory(Post::class)->create();

        // and a user
        $user = factory(User::class)->create();

        // that is logged in
        $this->actingAs($user);

        // *** when they like the post ***
        $post->like();

        // the we should see evidence in the db
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post)
        ]);

        // and the post should be liked
        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        // given I have a post
        $post = factory(Post::class)->create();

        // and a user
        $user = factory(User::class)->create();
 
        // that is logged in
        $this->actingAs($user);

        // and a post is liked
        $post->like();
 
        // *** when they unlike the post ***
        $post->unlike();
 
        // the we should see no evidence in the db
        $this->assertDatabaseMissing('likes', [
             'user_id' => $user->id,
             'likeable_id' => $post->id,
             'likeable_type' => get_class($post)
         ]);
 
        // and the post should not be liked
        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_can_toggle_a_post_like_status()
    {
        // given I have a post
        $post = factory(Post::class)->create();

        // and a user
        $user = factory(User::class)->create();
         
        // that is logged in
        $this->actingAs($user);
        
        // and a post is toggled
        $post->toggle();
         
        // then the post should be liked
        $this->assertTrue($post->isLiked());

        // and if it is toggled again
        $post->toggle();
                          
        // the post should not be liked
        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        // given I have a post
        $post = factory(Post::class)->create();

        // and a user
        $user = factory(User::class)->create();
         
        // that is logged in
        $this->actingAs($user);

        // and likes the post
        $post->toggle();

        // the post should find how many likes it has
        $this->assertEquals(1, $post->likesCount);

        // and a second user
        $user2 = factory(User::class)->create();
         
        // that is logged in
        $this->actingAs($user2);
        
        // and likes the same post
        $post->toggle();

        // the post should find how many likes it has
        $this->assertEquals(2, $post->likesCount);
    }
}
