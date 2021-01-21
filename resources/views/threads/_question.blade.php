<div class="card" v-if="!editing">
    <div class="card-header d-flex justify-content-between">
        <span>
            <img src="{{ $thread->user->avatar_path }}" class="avatar avatar-sm mr-2" />
            <a class="is-link" href="{{ route('profile', $thread->user->name) }}">{{ $thread->user->name }}</a> posted
            <span v-text="title"></span>
        </span>
        <div class="d-flex">
            @can('update', $thread)
            <button @click="editing = !editing" type="button" class="btn mr-2 is-sm btn-floating" title="Edit Thread">
                <i class="fa fa-edit"></i>
            </button>
            <form action="{{ $thread->path() }}" method="POST">
                @csrf
                @method('DELETE')
                <button title="Delete Thread" type="submit" class="btn btn-floating is-sm bg-danger">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
            @endcan
        </div>
    </div>

    <div class="card-body" v-text="body">
    </div>
</div>

<!-- Editng -->

<div class="card" v-else>
    <div class="card-header d-flex justify-content-between">
        <span>
            <img src="{{ $thread->user->avatar_path }}" class="avatar avatar-sm mr-2" />
            <a class="is-link" href="{{ route('profile', $thread->user->name) }}">{{ $thread->user->name }}</a> posted
            {{ $thread->title }}
        </span>
    </div>

    <div class="card-body">
        <form action="">
            <div class="form-group">
                <input type="text" v-model.trim="form.title" class="form-control" />
            </div>
            <div class="form-group">
                <textarea name="body" class="form-control" v-model.trim="form.body" rows="4"></textarea>
            </div>
        </form>
        <div class="d-flex mt-4 justify-content-end">
            <button @click="editing = !editing" type="button" class="btn mr-2" title="Cancel">Cancel</button>
            <button @click="updateThread" type="submit" class="btn btn-primary" title="Done">
                <i class="fa fa-check"></i> Update
            </button>
        </div>
    </div>
</div>