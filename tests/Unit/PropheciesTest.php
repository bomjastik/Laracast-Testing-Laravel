<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropheciesTest extends TestCase
{
    /** @test */
    public function it_normalized_a_string_for_a_cache_key()
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $cache->has('cache-key')->shouldBeCalled();

        $directive->setUp('cache-key');
//        $directive->setUp($collection);
//        $directive->setUp($model);


//        $directive = $this->prophesize(BladeDirective::class);
//        $directive->foo('bar')->shouldBeCalled()->willReturn('foobar');
//        $response = $directive->reveal()->foo('bar');
//        $this->assertSame('foobar', $response);
    }

    /** @test */
    public function it_normalized_an_array_for_a_cache_key()
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $cache->has('stub-cache-key')->shouldBeCalled();

        $directive->setUp(new ModelStub);
    }

    /** @test */
    public function it_normalized_a_cacheable_model_for_a_cache_key()
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $item = ['foo', 'bar'];

        $cache->has(md5('foobar'))->shouldBeCalled();

        $directive->setUp($item);
    }
}

class ModelStub
{
    public function getCacheKey()
    {
        return 'stub-cache-key';
    }
}

class RussianCache
{
    public function has()
    {

    }
}


class BladeDirective
{
    private $cache;

    public function __construct(RussianCache $cache)
    {
        $this->cache = $cache;
    }

    public function setUp($key)
    {
        $this->cache->has(
            $this->normalizeKey($key)
        );
    }

    protected function normalizeKey($item)
    {
        if (is_object($item) && method_exists($item, 'getCacheKey')) {
            return $item->getCacheKey();
        } elseif(is_array($item)) {
            return md5(implode('', $item));
        }

        return $item;
    }

//    public function foo()
//    {
//
//    }
}