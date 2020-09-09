@if($errors->any())

@php
$delay = 1000;
@endphp

<div class="d-flex z-9999 flex-column align-items-end px-2 w-100 position-absolute">
    <div class="w-25">
        @foreach($errors->all() as $error)
        <div data-autohide="true" data-delay="{{ $delay }}" class="toast ml-auto" role="alert">
            <div class="toast-header">
                <strong class="mr-auto">@lang('messages.words.error')</strong>
            </div>
            <div class="toast-body text-danger">
                {{ $error }}
            </div>
        </div>
        @php
        $delay = $delay + 2000
        @endphp
        @endforeach
    </div>
</div>
@enderror

@if(Session::has('success'))
<div class="d-flex z-9999 flex-column align-items-end px-2 w-100 position-absolute">
    <div class="w-25">
        <div data-autohide="true" data-delay="1500" class="toast bg-success ml-auto" role="alert">
            <div class="toast-header">
                <strong class="mr-auto">@lang('messages.words.success')</strong>
            </div>
            <div class="toast-body">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>
</div>
@endif