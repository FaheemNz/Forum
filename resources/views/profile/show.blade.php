@extends('layouts.app')

@section('content')
<a data-toggle="tooltip" data-placement="top" title="Create new Thread" href="{{ route('create_thread') }}" class="btn btn-floating is-fixed">+</a>

<div class="container">
    <div class="main-body">

        <div class="row gutters-sm">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <avatar-form :route="{{ json_encode(route('store_avatar', $profileUser->id)) }}" :user="{{ $profileUser }}"></avatar-form>
                            <div class="mt-3">
                                <h4>{{ $profileUser->name }}</h4>
                                <p class="text-secondary mb-1">Full Stack Developer</p>
                                <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                                <button class="btn btn-primary">Follow</button>
                                <button class="btn btn-outline-primary">Message</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><i class="fa fa-globe mr-2"></i>Website</h6>
                            <span class="text-secondary">https://bootdey.com</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><i class="fa fa-github mr-2"></i> Gitgub</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><i class="fa fa-twitter mr-2"></i> Twitter</h6>
                            <span class="text-secondary">@bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><i class="fa fa-instagram mr-2"></i> Instagram</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><i class="fa fa-facebook mr-2"></i> Facebook</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="timeline">
                    @forelse($activities as $activity)
                    @include("profile.activities.{$activity->type}")
                    @empty
                    <h4 class="text-center mt-4"><i class="fa fa-eye-slash mr-2"></i> No Activities yet...</h4>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection('content')