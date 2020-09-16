<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    public function test_an_authenticated_user_can_add_avatar()
    {
        $this->json('POST', 'api/users/{user}/avatar')->assertStatus(401);
    }

    public function test_a_valid_avatar_must_be_provided()
    {
        $this->signIn();

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar',  [
            'avatar' => 'xyz'
        ])
            ->assertStatus(422);
    }

    public function test_an_authenticated_user_can_add_an_avatar_to_their_profile()
    {
        $this->signIn();
        Storage::fake('public');
        
        $this->json('POST', 'api/users/' . auth()->id() . '/avatar',  [
            'avatar' => $file = UploadedFile::fake()->image('abc.png')->size(50)
        ])->assertStatus(204);
        
        $this->assertEquals(auth()->user()->avatar_path, asset('avatars/' . $file->hashName()));

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
