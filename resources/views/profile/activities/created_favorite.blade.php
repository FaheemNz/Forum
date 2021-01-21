@component('profile.activities.activity')

@slot('heading')

<span>{{ $activity->created_at }}</span>
<a href="" class="is-link"><i class="fa text-warning fa-star mr-2"></i> {{ $profileUser->name }} Favorited a reply...</a>

@endslot

@slot('body')

{{ $activity->subject->favoritable->body }}
<div>{{ $activity->subject->body }}</div>

@endslot

@endcomponent
