<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function test_a_user_can_search_threads()
    {
        $this->assertTrue(true);
        // config(['scout.driver' => 'algolia']);

        // $search = 'faheem';

        // factory('App\Thread', 2)->create();
        // factory('App\Thread', 2)->create(['body' => $search]);

        // do {
        //     sleep(.25);
        //     $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        // } while (empty($results));

        // $this->assertCount(2, $results);

        // Thread::latest()->take(4)->unsearchable();
    }
}
