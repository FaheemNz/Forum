@component('profile.activities.activity')
@slot('heading')
<span>{{ $activity->created_at }}</span>
<span>{{ $profileUser->name }} published a <a href="" class="is-link">new thread</a></span>
@endslot

@slot('body')
<h4>
    <a href="{{ $activity->subject->path() }}" class="is-link">{{ $activity->subject->title }}</a>
</h4>
<div>{{ $activity->subject->body }}</div>
@endslot
@endcomponent