<div class="card">
    <div class="card-header">
        <a href="#">{{ $reply->user->name }}</a> said {{ $reply->created_at }}
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
<br />