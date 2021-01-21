@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8">
                @include('threads._question', ['thread' => $thread])
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
        <div class="row mt-4">
            <div class="col">
                <ais-instant-search :search-client="searchClient" index-name="threads">
                    <ais-search-box></ais-search-box>
                    <ais-hits>
                        <div slot="item" slot-scope="{ item }">
                            <h2>@{{ item.title }}</h2>
                        </div>
                    </ais-hits>
                </ais-instant-search>
            </div>
        </div>
    </div>
</thread-view>

<button data-toggle="tooltip" title="Scroll to top" class="btn btn-floating is-fixed scroll-top">
    <i class="fa fa-long-arrow-up"></i>
</button>
@endsection