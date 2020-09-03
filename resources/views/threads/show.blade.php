@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="/threads">{{ __('messages.words.back') }}</a>
            <div class="card">
                <div class="card-header">
                    <a href="#">{{ $thread->user->name }}</a> posted 
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <br />

    <div class="row justify-content-center">
        <div class="col-md-8">
            <h6>{{ __('messages.words.replies') }}</h6>

            @foreach($thread->replies as $reply)
                <x-reply :reply="$reply" />
            @endforeach
        </div>
    </div>

    <br />

    <div class="row justify-content-center">
        <div class="col-md-8">
           @auth
                <x-reply-form :thread="$thread" />
           @endauth

           @guest
                <p>{{ __('messages.alerts.sign_in_required') }}</p>
           @endguest
        </div>
    </div>
</div>
@endsection