<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\MailTracking;

class MailTest extends TestCase
{
    use MailTracking;

    public function setUp()
    {
        parent::setUp();

        $this->setUpMailTracking();
    }

    /** @test */
    public function sentEmail()
    {
//        Mail::raw('Hello world', function ($message) {
//            $message->to('foo@bar.com');
//            $message->from('bar@foo.com');
//        });
//
//        Mail::raw('Hello world', function ($message) {
//            $message->to('foo@bar.com');
//            $message->from('bar@foo.com');
//        });
//
//        $this->seeEmailWasSent();
//
//        $this->seeEmailsSent(2)
//            ->seeEmailTo('foo@bar.com')
//            ->seeEmailFrom('bar@foo.com');
//
        $response = $this->get('/');

        $this->seeEmailWasSent();
    }
}
