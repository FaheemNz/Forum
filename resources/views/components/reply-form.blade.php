@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@enderror

@if(Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif

<form action="{{ route('add_reply_to_thread', $thread->id) }}" method="POST">
    <h5>@lang('messages.words.reply')</h5>
    @csrf
    <div class="form-group">
        <textarea required name="body" class="form-control" rows="5"></textarea>
    </div>

    <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">@lang('messages.words.submit')</button>
    </div>
</form>