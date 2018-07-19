<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_like_a_resource()
    {
        $post = factory(Post::class)->create();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $post->like();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);

        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_resource()
    {
        $post = factory(Post::class)->create();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $post->like();

        $post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_can_toggle_a_resource_like_status()
    {
        $post = factory(Post::class)->create();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $post->toggle();

        $this->assertTrue($post->isLiked());

        $post->toggle();

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function it_knows_how_many_likes_it_has()
    {
        $post = factory(Post::class)->create();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $post->like();

        $this->assertSame(1, $post->likesCount);

        $post->unlike();

        $this->assertSame(0, $post->likesCount);
    }


}
