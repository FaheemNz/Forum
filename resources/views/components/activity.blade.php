<h4 class="mb-3">Timeline...</h4>

<ol class="activity-feed">
    @forelse( $activities as $activity )
    <li class="feed-item">
        <time class="date">{{ $activity->created_at }}</time>
        <span class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a></span>
    </li>
    @empty
    <p>Haha...</p>
    @endforelse
</ol>

{{ $activities->links() }}