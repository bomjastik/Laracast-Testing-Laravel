<?php

namespace Tests\Feature\Models;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_trending_articles()
    {
        factory(Article::class, 2)->create();
        factory(Article::class)->create(['reads' => 10]);
        $mostPopular = factory(Article::class)->create(['reads' => 20]);

        $trendingArticles = Article::popular();

        $this->assertEquals($mostPopular->id, $trendingArticles->first()->id);
        $this->assertCount(3, $trendingArticles);
    }
}
