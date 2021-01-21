<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\User;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        //
    }

    public function show(User $user)
    {
        $userActivities = $this->profileService->getUserActivities($user);
       
        return view('profile.show', [
            'profileUser' => $user,
            'activities' => $userActivities
        ]);
    }

    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
