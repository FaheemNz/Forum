@if(count($trendingThreads))
<div class="{{ $customClass }}">
    <div class="card shadow">
        <div class="card-header">Trending Threads</div>
        <div class="card-body">
            <ul class="list-group">
                @foreach( $trendingThreads as $thread )
                <li class="list-group-item">
                    <a class="link" href="{{ $thread->path }}">{{ $thread->title }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif