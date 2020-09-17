@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread }}" inline-template>
    <div class="container">
        <button data-toggle="tooltip" title="Scroll to top" class="btn btn-floating is-fixed scroll-top">
            <i class="fa fa-long-arrow-up"></i>
        </button>
        <div class="row mt-4">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>
                            <img src="{{ $thread->user->avatar_path }}" class="avatar avatar-sm mr-2" />
                            <a class="is-link" href="{{ route('profile', $thread->user->name) }}">{{ $thread->user->name }}</a> posted
                            {{ $thread->title }}
                        </span>
                        @can('delete', $thread)
                        <form action="{{ $thread->path() }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-floating is-sm bg-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endauth
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <replies @added="repliesCount--" @removed="repliesCount++"></replies>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at }} by
                            <a href="{{ route('profile', $thread->user->name) }}">{{ $thread->user->name }}</a>
                            and it has <span v-text="repliesCount"></span> replies.
                        </p>
                        @auth
                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            @if( auth()->user()->isAdmin() )
                            <button @click="toggleThreadLock" type="button" class="btn" v-text="lockBtnText"></button>
                            @endif
                        </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </div>
</thread-view>
@endsection