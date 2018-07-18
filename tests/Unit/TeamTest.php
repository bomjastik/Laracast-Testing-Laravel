<?php

namespace Tests\Unit;

use App\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    /** @test */
    public function it_has_a_name()
    {
        $team = new Team(['name' => 'Acme']);

        $this->assertEquals('Acme', $team->name);
    }
}
