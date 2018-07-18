<?php

namespace Tests\Feature\Models;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_members()
    {
        $team = factory(Team::class)->create();

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $team->add($user1);
        $team->add($user2);

        $this->assertSame(2, $team->count());
    }

    /** @test */
    public function it_has_a_maximum_size()
    {
        $team = factory(Team::class)->create(['size' => 2]);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $team->add($user1);
        $team->add($user2);

        $this->assertSame(2, $team->count());

        $this->expectException('Exception');

        $user3 = factory(User::class)->create();

        $team->add($user3);
    }
    
    /** @test */
    public function it_can_add_multiple_members_at_once()
    {
        $team = factory(Team::class)->create();

        $users = factory(User::class, 2)->create();

        $team->add($users);

        $this->assertSame(2, $team->count());

//        $this->expectException('Exception');
//
//        $users = factory(User::class, 3)->create();
//
//        $team->add($users);
    }

    /** @test */
    public function it_can_remove_a_member()
    {
        $team = factory(Team::class)->create();

        $users = factory(User::class, 5)->create();

        $team->add($users);

        $this->assertSame(5, $team->count());

        $team->remove($users->first());

        $this->assertSame(4, $team->count());
    }

    /** @test */
    public function it_can_remove_multiple_members()
    {
        $team = factory(Team::class)->create();

        $users = factory(User::class, 3)->create();

        $team->add($users);

        $users = factory(User::class, 2)->create();

        $team->add($users);

        $this->assertSame(5, $team->count());

        $team->remove($users);

        $this->assertSame(3, $team->count());
    }
    
    /** @test */
    public function it_can_remove_all_members_at_once()
    {
        $team = factory(Team::class)->create();

        $users = factory(User::class, 3)->create();

        $team->add($users);

        $this->assertSame(3, $team->count());

        $team->clean();

        $this->assertSame(0, $team->count());
    }
}
