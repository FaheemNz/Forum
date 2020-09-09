<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <span>
            <a href="{{ route('profile', $reply->user->name) }}">{{ $reply->user->name }}</a> replied {{ $reply->created_at }}
        </span>
        <form method="POST" action="{{ route('favorite_the_reply', $reply) }}">
            @csrf
            <button type="submit" class="btn btn-success" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                Favorite ({{ $reply->favorites_count }})
            </button>
        </form>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>