@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-info" href="/threads">{{ __('messages.words.back') }}</a>
    <div class="row mt-4">
        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>
                        <a href="{{ route('profile', $thread->user->name) }}">{{ $thread->user->name }}</a> posted
                        {{ $thread->title }}
                    </span>
                    @can('delete', $thread)
                    <form action="{{ $thread->path() }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endauth
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>

            <h6>Replies</h6>
            @forelse($thread->replies as $reply)
            <x-reply :reply="$reply" />
            @empty
            <p class="alert alert-warning">@lang('messages.alerts.noReplies')</p>
            @endforelse

            <br />

            @auth
            <x-reply-form :thread="$thread" />
            @endauth

            @guest
            <p class="text-center">@lang('messages.alerts.sign_in_required')</p>
            @endguest
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>This thread was published {{ $thread->created_at }} by <a href="#">{{ $thread->user->name }}</a></p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection