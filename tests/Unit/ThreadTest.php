<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_an_owner()
    {
        $this->assertInstanceOf('App\User', $this->thread->user); 
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->actingAs(factory('App\User')->create());

        $this->post('/threads/' . $this->thread->id . '/replies', [
            'body' => 'Hello World this is a reply!'
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
