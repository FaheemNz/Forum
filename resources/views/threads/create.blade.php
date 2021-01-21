@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header">{{ __('messages.words.newThread') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store_thread') }}" id="threadForm">
                        @csrf
                        <div class="form-group">
                            <label for="channel_id">Select a Channel</label>
                            {{ old('title') }}
                            <select class="form-control" name="channel_id" id="channel_id">
                                @foreach($gChannels as $channel)
                                <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : '' }}>
                                    {{ $channel->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">@lang('messages.words.title')</label>
                            <input value="{{ old('title') }}" required type="text" class="form-control" id="title" name="title" placeholder="{{ __('messages.words.title') }}" />
                        </div>
                        <div class="form-group">
                            <label for="body">@lang('messages.words.body')</label>
                            <textarea required rows="5" class="form-control" id="body" name="body" placeholder="{{ __('messages.words.body') }}">{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group text-right">
                            <button data-sitekey="6Ld_Lc0ZAAAAACSdKjA1upl527SEOvP2WKhO8zsu" data-callback="onSubmit" data-action="submit" class="btn btn-primary g-recaptcha">
                                @lang('messages.words.publish')</button>
                        </div>
                    </form>

                    @if($errors->any())
                    @foreach($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit() {
        document.getElementById("threadForm").submit();
    }
</script>
@endsection