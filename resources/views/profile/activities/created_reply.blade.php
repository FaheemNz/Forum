@component('profile.activities.activity')
@slot('heading')
<span>{{ $activity->created_at }}</span>
<span><i class="fa fa-comment text-success mr-2"></i> {{ $profileUser->name }} replied...</span>
@endslot

@slot('body')
<h4>
    <a href="{{ $activity->subject->thread->path() }}" class="is-link">{{ $activity->subject->thread->title }}</a>
</h4>
<div>{{ $activity->subject->body }}</div>
@endslot
@endcomponent