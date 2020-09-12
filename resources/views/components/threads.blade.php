<div class="card shadow border-0">
    <div class="card-header">
        {{ $title }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>User</td>
                        <td>Topic</td>
                        <td>Channel</td>
                        <td>Replies</td>
                        <td>Activity</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($threads as $thread)
                    <tr>
                        <td>
                            <a href="{{ route('profile', $thread->user->name) }}" class="is-link">{{ $thread->user->name }}</a>
                        </td>
                        <td>
                            <a class="thread-title" href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </td>
                        <td>
                            <a class="badge badge-primary" href="{{ route('thread_channel', $thread->channel->slug) }}">
                                {{ $thread->channel->name }}
                                {{ $thread->channel->id }}
                            </a>
                        </td>
                        <td>{{ $thread->replies_count }}</td>
                        <td>{{ $thread->created_at }}</td>
                    </tr>
                    @empty
                    <p class="text-center">@lang('messages.alerts.noThreads')</p>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $threads->links() }}
</div>