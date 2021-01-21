<?php

namespace Tests\Unit;

use App\Activity;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    public function test_an_activity_is_recorded_on_thread_create()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();

        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->id(),
            'type' => 'created_thread',
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_an_activity_is_recorded_on_thread_reply()
    {
        $this->signIn();

        factory('App\Reply')->create();

        $this->assertEquals(2, Activity::count());
    }
}
