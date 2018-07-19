<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    private $post;

    public function setUp()
    {
        parent::setUp();

        $this->post = createPost();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_like_a_resource()
    {
        $this->post->like();

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_resource()
    {
        $this->post->like();

        $this->post->unlike();

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_toggle_a_resource_like_status()
    {
        $this->post->toggle();

        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function it_knows_how_many_likes_it_has()
    {
        $this->post->like();

        $this->assertSame(1, $this->post->likesCount);

        $this->post->unlike();

        $this->assertSame(0, $this->post->likesCount);
    }
}
