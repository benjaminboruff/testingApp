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
    public function a_user_can_like_it()
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
    public function a_user_can_unlike_it()
    {
    }
}
