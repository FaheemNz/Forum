@component('profile.activities.activity')
@slot('heading')
<span>{{ $activity->created_at }}</span>
<span><i class="fa fa-github text-primary mr-2"></i> <a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a> published a new thread</span>
@endslot

@slot('body')
<a href="{{ $activity->subject->path() }}" class="is-link">
    <h4>{{ $activity->subject->title }}</h4>
    <div>{{ $activity->subject->body }}</div>
</a>
@endslot
@endcomponent